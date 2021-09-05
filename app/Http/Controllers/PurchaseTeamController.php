<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\TotalRequirement;
use Illuminate\Http\Request;

class PurchaseTeamController extends Controller
{
    public function pendingOrders()
    {
        return \view('purchase-team.pending-order');
    }

    public function fetchTodaysTotalRequirements(Request $r)
    {
        $total = TotalRequirement::select()
            ->with('product', 'unit')
            ->orderBy('updated_at', 'asc')
            ->get();
        $total->load('product', 'unit');
        return $this->respondWithSuccess('Done', $total);
    }

    public function storeFullFilledOrder(Request $request)
    {
        $request->validate([
            'image' => 'required|image'
        ]);

        if ($request->hasFile('image')) {
            $photo = $request->file('image');
            $image_name = 'buying_challan_' . $request->product_id . "_$request->variant_" . Date('d-M-Y H:i:s') . '.' . $photo->extension();
            $photo->storeAs('purchase/images/', $image_name, 'public');
        }

        $this->data = [
            'product_id'    => $request->product_id,
            'unit_id'       => $request->unit_id,
            'variant'       => $request->variant,
            'required_qty'  => $request->required_qty,
            'supplied_qty'  => $request->supplied_qty,
            'total_price'   => $request->total_price,
            'image'         => $image_name,
        ];
        $updated = TotalRequirement::findOrFail($request->id)->update($this->data);
        return $this->respondWithSuccess("You are success", $updated);
    }
}
