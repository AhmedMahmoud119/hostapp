<?php

namespace App\Http\Controllers;

use App\Http\Helper\Helper;
use App\Http\Services\ActiveOrder;
use App\Http\Services\ClientLogin;
use App\Http\Services\Contact;
use App\Http\Services\OrderDomain;
use App\Http\Services\OrderMultiple;
use App\Http\Services\Product;
use App\Http\Services\SearchDomain;
use App\Models\HostJob;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function event(Request $request)
    {
        $request->validate([
            'event' => 'required',
        ], [
            'event.required' => 'الايفنت الزامي',
        ]);
        if ($request->event == 'client.login') {
            $userJawaly = Helper::verifyUserjawaly();
        }else{
            $userJawaly = auth()->user();
        }

        switch ($request->event) {
            case 'client.login':
                ClientLogin::clientLogin($userJawaly);
                break;
            case 'client.search.domain':
                $request->validate([
                    'data.name' => 'required',
                ], [
                    'data.name.required' => 'حقل الاسم الزامي',
                ]);
                SearchDomain::searchDomain($userJawaly);
                break;
            case 'client.order.domain':
                $request->validate([
                    'data.name' => 'required',
                    'data.years' => 'required',
                    'data.action' => 'required',
                ], [
                    'data.name.required' => 'حقل الاسم الزامي',
                    'data.years.required' => 'حقل السنين الزامي',
                    'data.action.required' => 'حقل الاكشن الزامي',
                ]);
                if ($request->data['action'] == 'transfer') {
                    $request->validate([
                        'data.epp' => 'required',
                    ], [
                        'data.epp.required' => 'حقل epp الزامي',
                    ]);
                }
                OrderDomain::orderDomain($userJawaly);
                break;
            case 'client.search.domain':
                break;
            case 'client.search.domain':
                break;
        }

        if ($request->event == 'client.login') {
            $token = ClientLogin::clientLogin($userJawaly);
        } else if ($request->event == 'client.search.domain') {
            $request->validate([
                'data.name' => 'required',
            ], [
                'data.name.required' => 'حقل الاسم الزامي',
            ]);
            $searchDomain = SearchDomain::searchDomain($userJawaly);
        }elseif ($request->event == 'client.order.domain') {
            $request->validate([
                'data.name' => 'required',
                'data.years' => 'required',
                'data.action' => 'required',
            ], [
                'data.name.required' => 'حقل الاسم الزامي',
                'data.years.required' => 'حقل السنين الزامي',
                'data.action.required' => 'حقل الاكشن الزامي',
            ]);
            if ($request->data['action'] == 'transfer') {
                $request->validate([
                    'data.epp' => 'required',
                ], [
                    'data.epp.required' => 'حقل epp الزامي',
                ]);
            }
            $orderDomain = OrderDomain::orderDomain($userJawaly);
        }elseif ($request->event == 'client.order.active') {
            $request->validate([
                'data.invoice_id' => 'required',
            ], [
                'data.invoice_id.required' => 'رقم الفاتوره الزامي',
            ]);
            $activeOrder = ActiveOrder::activeOrder($userJawaly);
        }elseif ($request->event == 'client.add.contact') {
            $request->validate([
                'data.firstname' => 'required',
                'data.lastname' => 'required',
                'data.email' => 'required',
            ]);
            $addContact = Contact::addContact($userJawaly);
        }elseif ($request->event == 'client.list.contact') {
            $getContact = Contact::getContacts($userJawaly);
        }elseif ($request->event == 'client.list.categories') {
            $getCategories = Product::getCategories($userJawaly);
        }elseif ($request->event == 'client.list.products') {
            $request->validate([
                'data.category_id' => 'required',
            ]);
            $getProducts = Product::getProducts($userJawaly);
        }elseif ($request->event == 'client.order.product') {
            $request->validate([
                'data.product_id' => 'required',
                'data.domain' => 'required',
                'data.cycle' => 'required',
            ]);
            $orderProduct = Product::orderProduct($userJawaly);
        }elseif ($request->event == 'client.order-multiple') {
            $request->validate([
                'data' => 'required|array',
                'data.*.type' => 'required',
            ], [
                'data.required' => 'حقل البيانات',
                'data.*.type.required' => 'حقل النوع الزامي',
            ]);
            $orderMultiple = OrderMultiple::orderMultiple($userJawaly);
        }elseif ($request->event == 'client.list.domains'){
            $listDomains = SearchDomain::listDomains($userJawaly);
        }elseif ($request->event == 'client.domain.details'){
            $request->validate([
                'data.id' => 'required',
            ]);
            $domainDetails = SearchDomain::domainDetails($userJawaly);
        }elseif ($request->event == 'client.create.dns'){
            $request->validate([
                'data.id' => 'required',
                'data.name' => 'required',
                'data.type' => 'required',
                'data.priority' => 'required',
                'data.content' => 'required',
            ]);
            SearchDomain::createDns($userJawaly);
        }elseif ($request->event == 'client.update.dns'){
            $request->validate([
                'data.id' => 'required',
                'data.record_id' => 'required',
                'data.name' => 'required',
                'data.type' => 'required',
                'data.priority' => 'required',
                'data.content' => 'required',
            ]);
            SearchDomain::updateDns($userJawaly);
        }elseif ($request->event == 'client.delete.dns'){
            $request->validate([
                'data.id' => 'required',
                'data.record_id' => 'required',
            ]);
            SearchDomain::deleteDns($userJawaly);
        }elseif ($request->event == 'client.dns.types'){
            $request->validate([
                'data.id' => 'required',
            ]);
            SearchDomain::dnsTypes($userJawaly);
        }elseif ($request->event == 'client.dns.records'){
            $request->validate([
                'data.id' => 'required',
            ]);
            SearchDomain::dnsRecords($userJawaly);
        }elseif ($request->event == 'client.domain.nameservers'){
            $request->validate([
                'data.id' => 'required',
            ]);
            SearchDomain::domainNs($userJawaly);
        }elseif ($request->event == 'client.update.nameservers'){
            $request->validate([
                'data.id' => 'required',
                'data.nameservers' => 'required|array'
            ]);
            SearchDomain::updateDomainNs($userJawaly);
        }elseif ($request->event == 'client.register.nameservers'){
            $request->validate([
                'data.id' => 'required',
            ]);
            SearchDomain::registerDomainNs($userJawaly);
        }elseif ($request->event == 'client.domain.epp'){
            $request->validate([
                'data.id' => 'required',
            ]);
            SearchDomain::domainEpp($userJawaly);
        }elseif ($request->event == 'client.domain.synchronize'){
            $request->validate([
                'data.id' => 'required',
            ]);
            SearchDomain::domainSynchronize($userJawaly);
        }elseif ($request->event == 'client.available.tld'){
            SearchDomain::availableTld($userJawaly);
        }

        return response()->json([
            'message' => 'تم الارسال بنجاح'
        ]);
    }

}
