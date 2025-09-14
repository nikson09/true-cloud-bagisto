@component('admin::emails.layout')
    <div style="margin-bottom: 34px;">
        @if($recipientName)
            <p style="font-weight: bold;font-size: 20px;color: #121A26;line-height: 24px;margin-bottom: 24px">
                @lang('admin::app.marketing.communications.email-broadcast.dear') {{ $recipientName }}, 👋
            </p>
        @else
            <p style="font-weight: bold;font-size: 20px;color: #121A26;line-height: 24px;margin-bottom: 24px">
                @lang('admin::app.marketing.communications.email-broadcast.hello') 👋
            </p>
        @endif
    </div>

    <div style="font-size: 20px;color: #242424;line-height: 30px;margin-bottom: 34px;">
        <div style="font-weight: bold;font-size: 20px;color: #242424;line-height: 30px;margin-bottom: 20px !important;">
            {{ $emailSubject }}
        </div>
        
        <div style="margin-top: 20px;line-height: 25px;font-size: 16px;color: #242424;">
            {!! $content !!}
        </div>
    </div>

    <div style="margin-top: 40px;padding-top: 20px;border-top: 1px solid #E5E7EB;">
        <p style="font-size: 16px;color: #202B3C;line-height: 24px;margin-bottom: 16px;">
            @lang('admin::app.marketing.communications.email-broadcast.thank-you'),
        </p>
    </div>
@endcomponent
