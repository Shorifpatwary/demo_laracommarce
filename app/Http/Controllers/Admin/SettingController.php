<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;

class SettingController extends Controller
{
    //seo page show method
    public function seo()
    {
        $data = DB::table('seos')->first();
        return view('setting.seo', compact('data'));
    }

    //update seo method
    public function seoUpdate(Request $request, $id)
    {
        $validatedData = $request->validate([
            'meta_title' => 'nullable|string|between:5,255',
            'meta_author' => 'nullable|string|between:5,255',
            'meta_tag' => 'nullable|string|between:5,255',
            'meta_keyword' => 'nullable|string|between:5,255',
            'meta_description' => 'nullable|string|between:5,255',
            'google_verification' => 'nullable|string|between:5,255',
            'alexa_verification' => 'nullable|string|between:5,255',
            'google_analytics' => 'nullable|string|between:5,255',
            'google_adsense' => 'nullable|string|between:5,255',
        ]);

        // Update the data in the database
        DB::table('seos')->where('id', $id)->update($validatedData);

        // Prepare a success notification
        $notification = [
            'notification' => 'SEO Setting Updated!',
            'alert-type' => 'success',
        ];

        // Redirect back with the notification
        return redirect()->back()->with($notification);
    }

    // //smtp setting page
    public function smtp()
    {
        // $smtp=DB::table('smtp')->first();
        return view('setting.smtp');
    }

    //smtp update
    public function smtpUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'mailer' => 'nullable|string|between:5,255',
            'host' => 'nullable|string|between:5,255',
            'port' => 'nullable|string|between:5,255',
            'user_name' => 'nullable|string|between:5,255',
            'password' => 'nullable|string|between:5,255',
        ]);

        DB::table('smtps')->where('id', $request->id)->update($validatedData);

        $notification = array('notification' => 'SMTP Setting Updated!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);

        // foreach ($request->types as $key => $type) {
        //     $this->updateEnvFile($type, $request[$type]);
        // }
        // $notification = array('messege' => 'SMTP Setting Updated!', 'alert-type' => 'success');
        // return redirect()->back()->with($notification);
    }

    // public function updateEnvFile($type, $val)
    // {
    //     $path = base_path('.env');
    //     if (file_exists($path)) {
    //         $val = '"' . trim($val) . '"';
    //         if (strpos(file_get_contents($path), $type) >= 0) {
    //             file_put_contents(
    //                 $path,
    //                 str_replace(
    //                     $type . '="' . env($type) . '"',
    //                     $type . '=' . $val,
    //                     file_get_contents($path)
    //                 )
    //             );
    //         } else {
    //             file_put_contents($path, file_get_contents($path) . $type . '=' . $val);
    //         }
    //     }
    // }


    // //website setting
    public function website()
    {
        $setting = DB::table('settings')->first();
        return view('setting.website-setting', compact('setting'));
    }

    // //website setting update
    public function WebsiteUpdate(Request $request)
    {
        $data = $request->validate([
            'currency' => 'nullable|string|max:25',
            'phone_one' => 'nullable|string|max:55',
            'phone_two' => 'nullable|string|max:55',
            'main_email' => 'nullable|email|max:100',
            'support_email' => 'nullable|email|max:100',
            'address' => 'nullable|string|max:1000',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'logo' => 'image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        if ($request->logo) {  //if user submit a new image
            $logo = $request->logo;
            $logo_name = uniqid() . '.' . $logo->getClientOriginalExtension();
            Image::make($logo)->resize(320, 120)->save('files/setting/' . $logo_name);
            $data['logo'] = 'files/setting/' . $logo_name;
        } else {   //jodi new logo na dey
            $data['logo'] = $request->old_logo;
        }

        if ($request->favicon) {  //if user submit a new image
            $favicon = $request->favicon;
            $favicon_name = uniqid() . '.' . $favicon->getClientOriginalExtension();
            Image::make($favicon)->resize(32, 32)->save('files/setting/' . $favicon_name);
            $data['favicon'] = 'files/setting/' . $favicon_name;
        } else {   //jodi new logo na dey
            $data['favicon'] = $request->old_favicon;
        }

        DB::table('settings')->where('id', $request->id)->update($data);
        $notification = array('notification' => 'Setting Updated!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    // //__payment gateway
    // public function PaymentGateway()
    // {
    //     $aamarpay = DB::table('payment_gateway_bd')->first();
    //     $surjopay = DB::table('payment_gateway_bd')->skip(1)->first();
    //     $ssl = DB::table('payment_gateway_bd')->skip(2)->first();
    //     return view('admin.bdpayment_gateway.edit', compact('aamarpay', 'surjopay', 'ssl'));
    // }

    // //__aamarpay update
    // public function AamarpayUpdate(Request $request)
    // {
    //     $data = array();
    //     $data['store_id'] = $request->store_id;
    //     $data['signature_key'] = $request->signature_key;
    //     $data['status'] = $request->status;
    //     DB::table('payment_gateway_bd')->where('id', $request->id)->update($data);
    //     $notification = array('messege' => 'Payment Gateway Update Updated!', 'alert-type' => 'success');
    //     return redirect()->back()->with($notification);
    // }

    // //__update surjopay
    // public function SurjopayUpdate(Request $request)
    // {
    //     $data = array();
    //     $data['store_id'] = $request->store_id;
    //     $data['signature_key'] = $request->signature_key;
    //     $data['status'] = $request->status;
    //     DB::table('payment_gateway_bd')->where('id', $request->id)->update($data);
    //     $notification = array('messege' => 'Payment Gateway Update Updated!', 'alert-type' => 'success');
    //     return redirect()->back()->with($notification);
    // }
}
