<?php

namespace Webkul\Admin\Http\Controllers\Marketing\Communications;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Admin\Mail\EmailBroadcastNotification;
use Webkul\Customer\Repositories\CustomerGroupRepository;
use Webkul\Customer\Repositories\CustomerRepository;

class EmailBroadcastController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected CustomerRepository $customerRepository,
        protected CustomerGroupRepository $customerGroupRepository,
    ) {}

    /**
     * Display the email broadcast form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $customerGroups = $this->customerGroupRepository->all();

        return view('admin::marketing.communications.email-broadcast.index', compact('customerGroups'));
    }

    /**
     * Send email to customers.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request): JsonResponse
    {
        \Log::info('Email broadcast request received', $request->all());
        
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'recipient_type' => 'required|in:group,email',
            'customer_group_id' => 'required_if:recipient_type,group|exists:customer_groups,id',
            'email_address' => 'required_if:recipient_type,email|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => trans('admin::app.marketing.communications.email-broadcast.validation-error'),
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $recipients = $this->getRecipients($request);

            if (empty($recipients)) {
                return response()->json([
                    'success' => false,
                    'message' => trans('admin::app.marketing.communications.email-broadcast.no-recipients'),
                ], 400);
            }

            $sentCount = 0;
            $failedCount = 0;

            foreach ($recipients as $recipient) {
                try {
                    Mail::queue(new EmailBroadcastNotification(
                        $request->input('subject'),
                        $request->input('content'),
                        $recipient['email'],
                        $recipient['name'] ?? ''
                    ));
                    $sentCount++;
                } catch (\Exception $e) {
                    $failedCount++;
                    Log::error('Email broadcast failed for ' . $recipient['email'] . ': ' . $e->getMessage());
                }
            }

            $message = trans('admin::app.marketing.communications.email-broadcast.send-success', [
                'sent' => $sentCount,
                'failed' => $failedCount,
            ]);

            return response()->json([
                'success' => true,
                'message' => $message,
                'sent_count' => $sentCount,
                'failed_count' => $failedCount,
            ]);

        } catch (\Exception $e) {
            Log::error('Email broadcast error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => trans('admin::app.marketing.communications.email-broadcast.send-error'),
            ], 500);
        }
    }

    /**
     * Get recipients based on request type.
     *
     * @param Request $request
     * @return array
     */
    public function getRecipients(Request $request): array
    {
        \Log::info('Getting recipients', [
            'recipient_type' => $request->recipient_type,
            'email_address' => $request->email_address,
            'customer_group_id' => $request->customer_group_id,
        ]);

        if ($request->recipient_type === 'email') {
            return [
                [
                    'email' => $request->email_address,
                    'name' => '',
                ]
            ];
        }

        // Get customers from selected group
        $customers = $this->customerRepository->findWhere([
            'customer_group_id' => $request->customer_group_id,
            'status' => 1, // Only active customers
        ]);

        \Log::info('Found customers', ['count' => $customers->count()]);

        return $customers->map(function ($customer) {
            return [
                'email' => $customer->email,
                'name' => $customer->name,
            ];
        })->toArray();
    }

    /**
     * Get customer count for a group.
     *
     * @param int $groupId
     * @return JsonResponse
     */
    public function getGroupCustomerCount(int $groupId): JsonResponse
    {
        $count = $this->customerRepository->findWhere([
            'customer_group_id' => $groupId,
            'status' => 1,
        ])->count();

        return response()->json([
            'count' => $count,
        ]);
    }
}
