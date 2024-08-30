<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\SubmitLoan;
use Carbon\Carbon;
use Illuminate\Http\Request;

// use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(){
        return SubmitLoan::all();
    }

    public function getListProductDanaInstant(Request $request)
    {
        $ret = (object) [];
        $ret->result = true;
        $ret->msg = '';
        $ret->count= '';
        $ret->limit= '';
        $ret->page = '';
        $ret->offset='';
        $ret->last_page = '';
        $ret->data = [];

        try {

            $product = SubmitLoan::select(
                'type',
                'created_at',
                'updated_at',
                'error_description',
                'order_id',
                'document_no',
                'otr',
                'dp',
                'status_pengajuan',
                'member_id',
                'nik',
                'is_sync',
                'approved'
            )->orderBy('created_at', 'desc');

            if (!empty($request->type)) {
                $product->where('type', empty($request->type) ? 'dana-instant' : $request->type);
            }

            if (!empty($request->status)) {
                $product->where('status_pengajuan', 'like', '%' . $request->status . '%');
            }

            if (!empty($request->is_approve)) {
                $product->where('approved', $request->is_approve == 'YES' ? 1 : 0);
            }

            if (!empty($request->keyword)) {
                if ($request->filter == 'name') {
                    $member = Member::select('name', '_id')->where('name', 'like',  '%' . $request->keyword . '%')->firstOrFail();
                    $product->where('member_id', $member['_id']);
                } else {
                    $product->where($request->filter, 'like', '%' . $request->keyword . '%');
                }
            }

            if (!empty($request->start_date)) {

                $start_date = Carbon::createFromFormat('Y-m-d', $request->start_date);
                $end_date = Carbon::createFromFormat('Y-m-d', $request->end_date);
                if (!empty($request->type)) {
                    $product->where('type', empty($request->type) ? 'dana-instant' : $request->type);
                } else {
                    $product->whereBetween('created_at', [
                        $start_date, $end_date
                    ])->where('type', empty($request->type) ? 'dana-instant' : $request->type);

                }
                // $product->whereDate('created_at', '>=', $request->start_date)
                //     ->whereDate('created_at', '<=', $request->end_date);
            }


            $data = $product->paginate((int)$request->limit ? (int)$request->limit : 10);
            $list = $data->getCollection()->transform(function ($item) {
                $member = Member::find($item->member_id);

                return [
                    'product' => ucwords(str_replace('-', ' ', $item->type)),
                    'order_id' => empty($item->order_id) ? '-' : $item->order_id,
                    'document_no' => empty($item->document_no) ? '-' : $item->document_no,
                    'requestor' => empty($member) ? '-' : $member->name,
                    'otr' => 'Rp ' . number_format((int)$item->otr, 0, ',', '.'),
                    'status' => $item->status_pengajuan,
                    'tgl_pengajuan' => gettype($item->created_at) == 'string' ? date("d M Y", strtotime($item->created_at)) : $item->created_at->toDateTime()->format("d M Y"),
                    'waktu_pengajuan' => date("H:i", strtotime($item->created_at)),
                    'tgl_update' => date("d M Y", strtotime($item->updated_at)),
                    'rejected_reason' => $item->error_description ? $item->error_description : '-',
                    'member_id' => $item->member_id,
                    'nik' => $item->nik,
                    'is_push' => $item->is_sync,
                    'is_approve' => $item->approved
                ];
            });

            $ret->page = $data->currentPage();
            $ret->last_page = $data->lastPage();
            $ret->count = $data->total();
            $ret->limit = (int)$data->perPage();
            $ret->offset = ($data->currentPage() - 1) * (int)$data->perPage();
            $ret->data = $list;
        } catch (\Exception $e) {
            $ret->result = false;
            $ret->msg = $e->getMessage();
        }
        return response()->json($ret);
    }
}