<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.marketing.communications.email-broadcast.title')
    </x-slot>

    {!! view_render_event('bagisto.admin.marketing.communications.email-broadcast.before') !!}

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Email Broadcast Form -->
    <div class="flex items-center justify-between">
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            @lang('admin::app.marketing.communications.email-broadcast.title')
        </p>
    </div>

    <!-- Form Container -->
    <div class="mt-3.5 flex gap-2.5 max-xl:flex-wrap">
        <!-- Left Section -->
        <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">
            {!! view_render_event('bagisto.admin.marketing.communications.email-broadcast.card.content.before') !!}

            <!-- Content Section -->
            <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                    @lang('admin::app.marketing.communications.email-broadcast.content')
                </p>

                <form id="email-broadcast-form">
                    @csrf
                    
                    <!-- Subject -->
                    <div class="mb-2.5">
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="required">
                                @lang('admin::app.marketing.communications.email-broadcast.subject')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                id="subject"
                                name="subject"
                                rules="required"
                                oninput="updateSendButton()"
                                :label="trans('admin::app.marketing.communications.email-broadcast.subject')"
                                :placeholder="trans('admin::app.marketing.communications.email-broadcast.subject-placeholder')"
                            />

                            <x-admin::form.control-group.error control-name="subject" />
                        </x-admin::form.control-group>
                    </div>

                    <!-- Content -->
                    <div class="mb-2.5">
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="required">
                                @lang('admin::app.marketing.communications.email-broadcast.message')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="textarea"
                                id="content"
                                name="content"
                                rules="required"
                                rows="10"
                                oninput="updateSendButton()"
                                :label="trans('admin::app.marketing.communications.email-broadcast.message')"
                                :placeholder="trans('admin::app.marketing.communications.email-broadcast.message-placeholder')"
                            />

                            <x-admin::form.control-group.error control-name="content" />
                        </x-admin::form.control-group>
                    </div>
                </form>
            </div>

            {!! view_render_event('bagisto.admin.marketing.communications.email-broadcast.card.content.after') !!}
        </div>

        <!-- Right Section -->
        <div class="flex w-[360px] max-w-full flex-col gap-2 max-md:w-full">
            {!! view_render_event('bagisto.admin.marketing.communications.email-broadcast.card.recipients.before') !!}

            <!-- Recipients Section -->
            <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                    @lang('admin::app.marketing.communications.email-broadcast.recipients')
                </p>

                <!-- Recipient Type -->
                <div class="mb-2.5">
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('admin::app.marketing.communications.email-broadcast.recipient-type')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="select"
                            id="recipient_type"
                            name="recipient_type"
                            rules="required"
                            class="cursor-pointer"
                            :label="trans('admin::app.marketing.communications.email-broadcast.recipient-type')"
                            onchange="toggleRecipientSections()"
                        >
                            <option value="">
                                @lang('admin::app.marketing.communications.email-broadcast.select-recipient-type')
                            </option>
                            <option value="group">
                                @lang('admin::app.marketing.communications.email-broadcast.customer-group')
                            </option>
                            <option value="email">
                                @lang('admin::app.marketing.communications.email-broadcast.single-email')
                            </option>
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error control-name="recipient_type" />
                    </x-admin::form.control-group>
                </div>

                <!-- Customer Group Selection -->
                <div class="mb-2.5" id="customer-group-section" style="display: none;">
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('admin::app.marketing.communications.email-broadcast.customer-group')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="select"
                            id="customer_group_id"
                            name="customer_group_id"
                            class="cursor-pointer"
                            onchange="updateSendButton()"
                            :label="trans('admin::app.marketing.communications.email-broadcast.customer-group')"
                        >
                            <option value="">
                                @lang('admin::app.marketing.communications.email-broadcast.select-group')
                            </option>

                            @foreach ($customerGroups as $group)
                                <option value="{{ $group->id }}">
                                    {{ $group->name }}
                                </option>
                            @endforeach
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error control-name="customer_group_id" />
                    </x-admin::form.control-group>

                    <!-- Customer Count Display -->
                    <div class="mt-2 text-sm text-gray-600 dark:text-gray-300" id="customer-count">
                        <span id="customer-count-text"></span>
                    </div>
                </div>

                <!-- Single Email Input -->
                <div class="mb-2.5" id="single-email-section" style="display: none;">
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('admin::app.marketing.communications.email-broadcast.email-address')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="email"
                            id="email_address"
                            name="email_address"
                            oninput="updateSendButton()"
                            :label="trans('admin::app.marketing.communications.email-broadcast.email-address')"
                            :placeholder="trans('admin::app.marketing.communications.email-broadcast.email-placeholder')"
                        />

                        <x-admin::form.control-group.error control-name="email_address" />
                    </x-admin::form.control-group>
                </div>

                <!-- Send Button -->
                <div class="mt-4">
                    <button
                        type="button"
                        id="send-email-btn"
                        class="primary-button w-full"
                        onclick="sendEmail()"
                        disabled
                    >
                        @lang('admin::app.marketing.communications.email-broadcast.send-email')
                    </button>
                </div>

                <!-- Status Messages -->
                <div id="status-messages" class="mt-4" style="display: none;">
                    <div id="success-message" class="hidden p-3 mb-2 text-sm text-green-800 bg-green-100 border border-green-200 rounded dark:bg-green-800 dark:text-green-100 dark:border-green-700"></div>
                    <div id="error-message" class="hidden p-3 mb-2 text-sm text-red-800 bg-red-100 border border-red-200 rounded dark:bg-red-800 dark:text-red-100 dark:border-red-700"></div>
                </div>
            </div>

            {!! view_render_event('bagisto.admin.marketing.communications.email-broadcast.card.recipients.after') !!}
        </div>
    </div>

    {!! view_render_event('bagisto.admin.marketing.communications.email-broadcast.after') !!}

    <script>
        // Simple JavaScript for email broadcast
        function toggleRecipientSections() {
            const recipientType = document.getElementById('recipient_type').value;
            const groupSection = document.getElementById('customer-group-section');
            const emailSection = document.getElementById('single-email-section');
            
            // Hide both sections first
            if (groupSection) groupSection.style.display = 'none';
            if (emailSection) emailSection.style.display = 'none';
            
            // Show appropriate section
            if (recipientType === 'group' && groupSection) {
                groupSection.style.display = 'block';
            } else if (recipientType === 'email' && emailSection) {
                emailSection.style.display = 'block';
            }
            
            updateSendButton();
        }
        
        function updateSendButton() {
            const subject = document.getElementById('subject').value.trim();
            const content = document.getElementById('content').value.trim();
            const recipientType = document.getElementById('recipient_type').value;
            const sendButton = document.getElementById('send-email-btn');
            
            let isValid = subject !== '' && content !== '' && recipientType !== '';
            
            if (recipientType === 'group') {
                const groupId = document.getElementById('customer_group_id').value;
                isValid = isValid && groupId !== '';
            } else if (recipientType === 'email') {
                const email = document.getElementById('email_address').value.trim();
                isValid = isValid && email !== '';
            }
            
            if (sendButton) {
                sendButton.disabled = !isValid;
            }
        }
        
        function sendEmail() {
            const sendButton = document.getElementById('send-email-btn');
            if (sendButton && sendButton.disabled) {
                alert('Пожалуйста, заполните все обязательные поля');
                return;
            }
            
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('subject', document.getElementById('subject').value);
            formData.append('content', document.getElementById('content').value);
            formData.append('recipient_type', document.getElementById('recipient_type').value);
            
            const recipientType = document.getElementById('recipient_type').value;
            if (recipientType === 'group') {
                formData.append('customer_group_id', document.getElementById('customer_group_id').value);
            } else if (recipientType === 'email') {
                formData.append('email_address', document.getElementById('email_address').value);
            }
            
            // Show loading
            if (sendButton) {
                sendButton.disabled = true;
                sendButton.textContent = 'Отправка...';
            }
            
            fetch('{{ route("admin.marketing.communications.email-broadcast.send") }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Email отправлен успешно! Отправлено: ' + data.sent_count + ', Не удалось: ' + data.failed_count);
                    // Reset form
                    document.getElementById('email-broadcast-form').reset();
                    toggleRecipientSections();
                } else {
                    alert('Ошибка: ' + data.message);
                }
            })
            .catch(error => {
                alert('Ошибка отправки: ' + error.message);
            })
            .finally(() => {
                if (sendButton) {
                    sendButton.disabled = false;
                    sendButton.textContent = '{{ trans("admin::app.marketing.communications.email-broadcast.send-email") }}';
                }
                updateSendButton();
            });
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Email broadcast page loaded');
            updateSendButton();
        });
    </script>
</x-admin::layouts>
