<?php
namespace App;

use App, Log, Mail;
use App\Mail\SendEmail;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    protected $fillable = ['title', 'subject', 'content'];

    public static $emails = [
        'default'                         => [
            'body'      => '',
            'desc'      => 'Body One Section',
            'subject'   => '-',
            'to'        => '-',
            'variables' => ['Main Content'],
        ],
        'customer.contact'                => [
            'body'      => 'default',
            'desc'      => 'Customer Contact Us email',
            'subject'   => 'Thank you for getting in touch!',
            'to'        => 'Customer',
            'variables' => ['Customer Name', 'Customer Email', 'Customer Telephone', 'Customer Comment'],
        ],
        'admin.contact'                   => [
            'body'      => 'default',
            'desc'      => 'Admin Contact Us email',
            'subject'   => 'Contact Us Enquiry Received',
            'to'        => 'Admin',
            'variables' => ['Customer Name', 'Customer Email', 'Customer Telephone', 'Customer Comment'],
        ],
        'admin.become-a-distributor'                   => [
            'body'      => 'default',
            'desc'      => 'Admin Become A Distributor email',
            'subject'   => 'Become a Distributor Enquiry Received',
            'to'        => 'Admin',
            'variables' => ['Name', 'Email', 'Company Name', 'State', 'Phone', 'Product Interest'],
        ],
        'customer.sds'                    => [
            'body'      => 'default',
            'desc'      => 'Customer Sds email',
            'subject'   => 'Thank you for your interest in our products',
            'to'        => 'Customer',
            'variables' => ['Customer Name', 'Sds Username', 'Sds Password', 'Sds Email', 'Sds Link'],
        ],
        'admin.sds'                       => [
            'body'      => 'default',
            'desc'      => 'Admin Sds email',
            'subject'   => 'SDS Enquiry Received',
            'to'        => 'Admin',
            'variables' => ['Customer Name', 'Company Name', 'Customer Email', 'Customer Telephone', 'Website', 'Product'],
        ],
        'customer.change_password'        => [
            'body'      => 'default',
            'desc'      => 'Customer Password Change email',
            'subject'   => 'Change Password Notification !',
            'to'        => 'Customer',
            'variables' => ['Customer Name'],
        ],
        'customer.registration'           => [
            'body'      => 'default',
            'desc'      => 'Customer Registration email',
            'subject'   => 'Registration Successful !',
            'to'        => 'Customer',
            'variables' => ['Customer Name'],
        ],
        'customer.change_password'        => [
            'body'      => 'default',
            'desc'      => 'Customer Password Change email',
            'subject'   => 'Change Password Notification !',
            'to'        => 'Customer',
            'variables' => ['Customer Name', 'Customer Email'],
        ],
        'admin.reset_link'                => [
            'body'      => 'default',
            'desc'      => 'Admin Reset Password Link email',
            'subject'   => 'Reset Password Link !',
            'to'        => 'Admin',
            'variables' => ['Admin Name', 'token'],
        ],
        'customer.reset_link'             => [
            'body'      => 'default',
            'desc'      => 'Customer Reset Password Link email',
            'subject'   => 'Reset Password Link !',
            'to'        => 'Customer',
            'variables' => ['Customer Name', 'token'],
        ],
        'customer.reset_link_big_users'             => [
            'body'      => 'default',
            'desc'      => 'Customer Reset Password Link email to BigCommerce Users',
            'subject'   => 'Generalchem.com Reset Password Link !',
            'to'        => 'Customer',
            'variables' => ['Customer Name', 'token'],
        ],
        'customer.reset_password'         => [
            'body'      => 'default',
            'desc'      => 'Customer Reset Password email',
            'subject'   => 'Reset Password Notification !',
            'to'        => 'Customer',
            'variables' => ['Customer Name', 'Customer Email'],
        ],
        "customer.order_confirm"          => [
            'body'      => 'default',
            'desc'      => 'Customer Order Confirm email',
            'subject'   => 'Your order #[Order ID] has been successfully placed.',
            'to'        => 'Customer',
            'variables' => ['Customer Name', 'Order ID', 'Product Table'],
        ],
        "admin.order_confirm"             => [
            'body'      => 'default',
            'desc'      => 'Order Email to Admin',
            'subject'   => 'New order #[Order ID] is placed.',
            'to'        => 'Admin',
            'variables' => ['Customer Name', 'Order ID', 'Product Table'],
        ],
        "customer.cancel_order_from_user" => [
            'body'      => 'default',
            'desc'      => 'Customer Order cancelled email',
            'subject'   => 'Your order #[Order ID] is cancelled successfully.',
            'to'        => 'Customer',
            'variables' => ['Customer Name', 'Order ID', 'Product Table'],
        ],
        "admin.cancel_order_from_user"    => [
            'body'      => 'default',
            'desc'      => 'Customer Order cancelled to admin email',
            'subject'   => 'Order #[Order ID] is cancelled.',
            'to'        => 'Admin',
            'variables' => ['Customer Name', 'Order ID', 'Product Table', 'Cancelled Reason'],
        ],
        "customer.order_cancelled"        => [
            'body'      => 'default',
            'desc'      => 'Customer Order cancelled by admin email',
            'subject'   => 'Your order #[Order ID] has been declined/cancelled',
            'to'        => 'Customer',
            'variables' => ['Customer Name', 'Order ID', 'Product Table'],
        ],
        "customer.order_awaiting_pickup"  => [
            'body'      => 'default',
            'desc'      => 'Customer Order awaiting pickup email',
            'subject'   => 'Your order #[Order ID] is ready for pickup',
            'to'        => 'Customer',
            'variables' => ['Customer Name', 'Order ID', 'Product Table'],
        ],
        "customer.order_shipped"          => [
            'body'      => 'default',
            'desc'      => 'Customer Order Shipped email',
            'subject'   => 'Your order #[Order ID] is Shipped!',
            'to'        => 'Customer',
            'variables' => ['Customer Name', 'Order ID', 'Product Table','Tracking Text','Tracking Provider','Tracking Number'],
        ],
        "customer.order_completed"        => [
            'body'      => 'default',
            'desc'      => 'Customer Order Completion email',
            'subject'   => 'Your order #[Order ID] is Completed!',
            'to'        => 'Customer',
            'variables' => ['Customer Name', 'Order ID', 'Product Table'],
        ],
        "customer.newsletter"             => [
            'body'      => 'default',
            'desc'      => 'Customer SignUp for deals email',
            'subject'   => 'SIGNUP for Deals Successful !',
            'to'        => 'Customer',
            'variables' => ['Customer Email', 'Unsubscribe Link'],
        ],
        'customer.category_enquiry'                => [
            'body'      => 'default',
            'desc'      => 'Category Enquiry email',
            'subject'   => 'Thank you for getting in touch!',
            'to'        => 'Customer',
            'variables' => ['Customer First Name', 'Customer Last Name'],
        ],
        'admin.category_enquiry'                   => [
            'body'      => 'default',
            'desc'      => 'Category Enquiry email',
            'subject'   => 'Category Enquiry Received',
            'to'        => 'Admin',
            'variables' => ['Customer First Name', 'Customer Last Name', 'Customer Company Name', 'Customer Email','Customer Telephone','Customer Street Address','Customer Address Line 2','Customer City','Customer State','Customer Zipcode','Customer Country','Customer Process Time','Customer Temperature','Customer Concentration','Customer SOAK','Customer Reference','Customer Special Requirement','Customer Comments'],
        ],
    ];

    public static function getEmails()
    {
        // get all admin emails
        $emails = Email::$emails;
        foreach ($emails as $key => $email) {
            $emails[$key] = Email::getEmail($key);
        }
        return $emails;
    }
    public static function getEmail($id)
    {
        if (!isset(Email::$emails[$id])) {
            return false;
        }

        $email  = Email::$emails[$id];
        $fromDB = Email::where('title', $id)->first();
        if ($fromDB) {
            $email['content'] = $fromDB->content;
            $email['subject'] = $fromDB->subject;
            $email['fromDB']  = true;
        } else {
            $view             = view('emails.' . $id);
            $contents         = $view->render();
            $email['content'] = $contents;
            $email['fromDB']  = false;
        }
        return $email;
    }
    public static function sendEmail($id, $placeHolders, $to, $dispatchable = false)
    {
        $emailData = Self::getEmail($id);
        
        if (!empty($emailData['body'])) {
            $body                 = Email::getEmail($emailData['body']);
            $emailData['content'] = str_ireplace('[Main Content]', $emailData['content'], $body['content']);
        }
        
        foreach ($placeHolders as $placeholder => $replaceWith) {
            $emailData['content'] = str_replace($placeholder, $replaceWith, $emailData['content']);
            $emailData['subject'] = str_replace($placeholder, $replaceWith, $emailData['subject']);
        }
        
        if (!empty($to) && strpos($to,",") > 0) {
            $to = explode(",", $to);
            $to = array_map('trim', $to);
        }

        $mail = new SendEmail($emailData);

        if (
            (isset($placeHolders['[Customer Email]']) && trim($placeHolders['[Customer Email]']) !== '') &&
            (strpos($id, 'admin.') !== false)
        ) {
            $mail->replyTo(trim($placeHolders['[Customer Email]']));
            return Mail::to($to)->send($mail);
        }

        if (trim(setting('email')) !== '') {
            $mail->replyTo(setting('email'));
        }

        if($dispatchable){
            return Mail::to($to)->queue($mail);
        }else{
            return Mail::to($to)->send($mail);
        }
    }
}
