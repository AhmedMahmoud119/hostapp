<?php

namespace App\Http\Controllers;

use App\Http\Helper\Helper;
use App\Http\Services\ActiveOrder;
use App\Http\Services\Certificate;
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
            case 'client.order.active':
                $request->validate([
                    'data.invoice_id' => 'required',
                ], [
                    'data.invoice_id.required' => 'رقم الفاتوره الزامي',
                ]);
                ActiveOrder::activeOrder($userJawaly);
                break;
            case 'client.add.contact':
                $request->validate([
                    'data.firstname' => 'required',
                    'data.lastname' => 'required',
                    'data.email' => 'required',
                ]);
                Contact::addContact($userJawaly);
                break;
            case 'client.list.contact':
                Contact::getContacts($userJawaly);
                break;
            case 'client.list.categories':
                Product::getCategories($userJawaly);
                break;
            case 'client.list.products':
                $request->validate([
                    'data.category_id' => 'required',
                ]);
                Product::getProducts($userJawaly);
                break;
            case 'client.list.products-in-details':
                $request->validate([
                    'data.category_id' => 'required',
                ]);
                Product::getProducts($userJawaly,1);
                break;
            case 'client.product.configuration':
                $request->validate([
                    'data.product_id' => 'required',
                ]);
                Product::getProductConfigurationDetails($userJawaly);
                break;
            case 'client.order.product':
                $request->validate([
                    'data.product_id' => 'required',
                    'data.domain' => 'required',
                    'data.cycle' => 'required',
                ]);
                Product::orderProduct($userJawaly);
                break;
            case 'client.order-multiple':
                $request->validate([
                    'data' => 'required|array',
                    'data.*.type' => 'required',
                ], [
                    'data.required' => 'حقل البيانات',
                    'data.*.type.required' => 'حقل النوع الزامي',
                ]);
                OrderMultiple::orderMultiple($userJawaly);
                break;
            case 'client.list.domains':
                SearchDomain::listDomains($userJawaly);
                break;
            case 'client.domain.details':
                $request->validate([
                    'data.id' => 'required',
                ]);
                SearchDomain::domainDetails($userJawaly);
                break;
            case 'client.create.dns':
                $request->validate([
                    'data.id' => 'required',
                    'data.name' => 'required',
                    'data.type' => 'required',
                    'data.priority' => 'required',
                    'data.content' => 'required',
                ]);
                SearchDomain::createDns($userJawaly);
                break;
            case 'client.update.dns':
                $request->validate([
                    'data.id' => 'required',
                    'data.record_id' => 'required',
                    'data.name' => 'required',
                    'data.type' => 'required',
                    'data.priority' => 'required',
                    'data.content' => 'required',
                ]);
                SearchDomain::updateDns($userJawaly);
                break;
            case 'client.delete.dns':
                $request->validate([
                    'data.id' => 'required',
                    'data.record_id' => 'required',
                ]);
                SearchDomain::deleteDns($userJawaly);
                break;
            case 'client.dns.types':
                $request->validate([
                    'data.id' => 'required',
                ]);
                SearchDomain::dnsTypes($userJawaly);
                break;
            case 'client.dns.records':
                $request->validate([
                    'data.id' => 'required',
                ]);
                SearchDomain::dnsRecords($userJawaly);
                break;
            case 'client.domain.nameservers':
                $request->validate([
                    'data.id' => 'required',
                ]);
                SearchDomain::domainNs($userJawaly);
                break;
            case 'client.update.nameservers':
                $request->validate([
                    'data.id' => 'required',
                    'data.nameservers' => 'required|array'
                ]);
                SearchDomain::updateDomainNs($userJawaly);
                break;
            case 'client.register.nameservers':
                $request->validate([
                    'data.id' => 'required',
                ]);
                SearchDomain::registerDomainNs($userJawaly);
                break;
            case 'client.domain.epp':
                $request->validate([
                    'data.id' => 'required',
                ]);
                SearchDomain::domainEpp($userJawaly);
                break;
            case 'client.domain.synchronize':
                $request->validate([
                    'data.id' => 'required',
                ]);
                SearchDomain::domainSynchronize($userJawaly);
                break;
            case 'client.available.tld':
                SearchDomain::availableTld($userJawaly);
                break;
            case 'client.domain.lock':
                $request->validate([
                    'data.id' => 'required',
                ]);
                SearchDomain::domainLock($userJawaly);
                break;
            case 'client.domain.update.lock':
                $request->validate([
                    'data.id' => 'required',
                ]);
                SearchDomain::updateDomainLock($userJawaly);
                break;
            case 'client.domain.update.idprotection':
                $request->validate([
                    'data.id' => 'required',
                ]);
                SearchDomain::updateDomainIdProtection($userJawaly);
                break;
            case 'client.domain.contact':
                $request->validate([
                    'data.id' => 'required',
                ]);
                SearchDomain::domainContact($userJawaly);
                break;
            case 'client.domain.update.contact':
                $request->validate([
                    'data.id' => 'required',
                ]);
                SearchDomain::updateDomainContact($userJawaly);
                break;
            case 'client.domain.emforwarding':
                $request->validate([
                    'data.id' => 'required',
                ]);
                SearchDomain::domainEmforwarding($userJawaly);
                break;
            case 'client.domain.update.emforwarding':
                $request->validate([
                    'data.id' => 'required',
                ]);
                SearchDomain::updateDomainEmforwarding($userJawaly);
                break;
            case 'client.domain.update.forwarding':
                $request->validate([
                    'data.id' => 'required',
                ]);
                SearchDomain::updateDomainForwarding($userJawaly);
                break;
            case 'client.domain.autorenew':
                $request->validate([
                    'data.id' => 'required',
                ]);
                SearchDomain::domainAutorenew($userJawaly);
                break;
            case 'client.domain.update.autorenew':
                $request->validate([
                    'data.id' => 'required',
                ]);
                SearchDomain::updateDomainAutorenew($userJawaly);
                break;
            case 'client.domain.flags':
                $request->validate([
                    'data.id' => 'required',
                ]);
                SearchDomain::domainFlags($userJawaly);
                break;
            case 'client.domain.dnssec':
                $request->validate([
                    'data.id' => 'required',
                ]);
                SearchDomain::domainDnssec($userJawaly);
                break;
            case 'client.domain.add.dnssec':
                $request->validate([
                    'data.id' => 'required',
                ]);
                SearchDomain::addDomainDnssec($userJawaly);
                break;
            case 'client.domain.tld.form':
                $request->validate([
                    'data.tld_id' => 'required',
                ]);
                SearchDomain::tldForm($userJawaly);
                break;
            case 'client.domain.renew':
                $request->validate([
                    'data.id' => 'required',
                    'data.years' => 'required',
                ]);
                SearchDomain::domainRenew($userJawaly);
                break;
            case 'client.available.certificates':
                Certificate::listAvailableCertificates($userJawaly);
                break;
            case 'client.certificate.list':
                Certificate::listCertificates($userJawaly);
                break;
            case 'client.certificate.order':
                $request->validate([
                    'data.product_id' => 'required',
                ]);
                Certificate::orderCertificate($userJawaly);
                break;
            case 'client.certificate.details':
                $request->validate([
                    'data.id' => 'required',
                ]);
                Certificate::certificateDetails($userJawaly);
                break;
        }

        return response()->json([
            'message' => 'تم الارسال بنجاح'
        ]);
    }

}
