<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use App\Models\Product;
use App\Models\Requirement;
use App\Models\TotalRequirement;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;

class RootSmgManagerController extends Controller
{
    protected int $id;

    public function todaysRequirement()
    {
        $id = [];
        foreach (auth()->user()->unreadnotifications as $notification) {
            \array_push($id, $notification->data['requirements']['zone_id']);
        }

        $zones = Zone::select()
            ->whereIn('id', $id)
            ->get();
        return \view('root-smg-manager.index', \compact('zones'));
    }

    public function todaysRequirementShow($id)
    {
        $this->id = $id;
        $zone = Zone::select()
            ->where('id', $id)
            ->whereHas('requirements', function ($q) {
                $q->where('zone_id', $this->id);
            })
            ->first();
        $zone->load('requirements.product', 'requirements.unit');

        return \view('root-smg-manager.show', \compact('zone'));
    }

    public function todaysRequirementCount()
    {
        $id = [];
        foreach (auth()->user()->unreadnotifications as $notification) {
            \array_push($id, $notification->data['requirements']['zone_id']);
        }

        $zones = Zone::select()
            ->whereIn('id', $id)
            ->get();
        return $this->respondWithSuccess('You have got the Total todays requirements', ['todaysOrder' => $zones->count()]);
    }

    public function todaysTotalRequirements()
    {
        return \view('root-smg-manager.total-requirements');
    }

    public function fetchTodaysTotalRequirements()
    {
        /*         $productIds = Requirement::select('product_id')->get();

        $products = Product::select('id', 'sizes')->whereIn('id', $productIds)->get();

        $productVariants = Requirement::select('variant')->get();

        foreach ($products as $product) {
            $var = Requirement::select('variant')->get();
        }
 */
        $reqs = Requirement::all();
        $reqs->load('product', 'unit');
        return $this->respondWithSuccess('You are successfully fetched', $reqs);
    }

    public function storeTodaysTotalRequirements(Request $r)
    {
        foreach ($r->all() as $req) {
            TotalRequirement::create($req);
        }
        return $this->respondWithSuccess('Done');
    }
}
