<x-layouts.app :title="__('Help & Support')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">📞 Help & Support</h1>
            <p class="text-zinc-600 dark:text-zinc-400 mt-1">Get help and contact the subdivision security office</p>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <!-- Contact Options -->
            <div class="space-y-4">
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 mb-4">Contact Us</h2>

                <!-- Chat Support -->
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 bg-white dark:bg-zinc-800 hover:shadow-lg transition">
                    <div class="flex items-start gap-4">
                        <div class="text-3xl">💬</div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-2">Live Chat</h3>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-4">Chat with security office staff during business hours</p>
                            <button onclick="openChat()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                                Start Chat
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Phone Support -->
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 bg-white dark:bg-zinc-800 hover:shadow-lg transition">
                    <div class="flex items-start gap-4">
                        <div class="text-3xl">☎️</div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-2">Call Us</h3>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-2">Available 24/7 for emergencies</p>
                            <p class="text-lg font-mono font-bold text-blue-600 dark:text-blue-400 mb-2">
                                +1 (555) 123-4567
                            </p>
                            <button onclick="callSupport()" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition">
                                Call Now
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Email Support -->
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 bg-white dark:bg-zinc-800 hover:shadow-lg transition">
                    <div class="flex items-start gap-4">
                        <div class="text-3xl">✉️</div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-2">Email Support</h3>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-2">Send us an email for detailed inquiries</p>
                            <p class="text-sm font-mono text-blue-600 dark:text-blue-400 mb-3">
                                security@subdivision.com
                            </p>
                            <a href="mailto:security@subdivision.com" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-sm font-medium transition inline-block">
                                Send Email
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQs -->
            <div>
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 mb-4">Frequently Asked Questions</h2>
                
                <div class="space-y-3">
                    <!-- FAQ Item 1 -->
                    <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl overflow-hidden bg-white dark:bg-zinc-800">
                        <button onclick="toggleFAQ(1)" class="w-full px-6 py-4 flex items-center justify-between hover:bg-zinc-50 dark:hover:bg-zinc-700 transition">
                            <h4 class="font-semibold text-zinc-900 dark:text-zinc-100 text-left">Why was my gate access denied?</h4>
                            <span id="faq-icon-1" class="text-2xl transition transform">+</span>
                        </button>
                        <div id="faq-content-1" class="hidden px-6 pb-4 border-t border-zinc-200 dark:border-zinc-700 text-sm text-zinc-600 dark:text-zinc-400">
                            <p>Gate access may be denied if:</p>
                            <ul class="list-disc list-inside mt-2 space-y-1">
                                <li>Your vehicle plate is not registered in the system</li>
                                <li>Your resident profile is inactive or suspended</li>
                                <li>There's a mismatch between your plate and registered vehicle</li>
                                <li>Your subscription/membership has expired</li>
                            </ul>
                            <p class="mt-3">Contact support if you believe this is an error.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl overflow-hidden bg-white dark:bg-zinc-800">
                        <button onclick="toggleFAQ(2)" class="w-full px-6 py-4 flex items-center justify-between hover:bg-zinc-50 dark:hover:bg-zinc-700 transition">
                            <h4 class="font-semibold text-zinc-900 dark:text-zinc-100 text-left">How long does it take to approve my profile changes?</h4>
                            <span id="faq-icon-2" class="text-2xl transition transform">+</span>
                        </button>
                        <div id="faq-content-2" class="hidden px-6 pb-4 border-t border-zinc-200 dark:border-zinc-700 text-sm text-zinc-600 dark:text-zinc-400">
                            <p>Profile update requests are typically reviewed and approved within:</p>
                            <ul class="list-disc list-inside mt-2 space-y-1">
                                <li><strong>24-48 hours:</strong> Standard requests (personal info, address)</li>
                                <li><strong>2-3 days:</strong> Vehicle-related changes (plate, car model)</li>
                                <li>Emergency requests may be expedited</li>
                            </ul>
                            <p class="mt-3">You'll receive a notification once your request is processed.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 3 -->
                    <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl overflow-hidden bg-white dark:bg-zinc-800">
                        <button onclick="toggleFAQ(3)" class="w-full px-6 py-4 flex items-center justify-between hover:bg-zinc-50 dark:hover:bg-zinc-700 transition">
                            <h4 class="font-semibold text-zinc-900 dark:text-zinc-100 text-left">How can I view my gate access history?</h4>
                            <span id="faq-icon-3" class="text-2xl transition transform">+</span>
                        </button>
                        <div id="faq-content-3" class="hidden px-6 pb-4 border-t border-zinc-200 dark:border-zinc-700 text-sm text-zinc-600 dark:text-zinc-400">
                            <p>Your complete gate access history is available in the <strong>Gate Access Logs</strong> section. Here you can:</p>
                            <ul class="list-disc list-inside mt-2 space-y-1">
                                <li>View all entry and exit timestamps</li>
                                <li>See the captured plate images</li>
                                <li>Check authorization status (authorized/unauthorized)</li>
                                <li>Filter and search by date or time</li>
                            </ul>
                        </div>
                    </div>

                    <!-- FAQ Item 4 -->
                    <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl overflow-hidden bg-white dark:bg-zinc-800">
                        <button onclick="toggleFAQ(4)" class="w-full px-6 py-4 flex items-center justify-between hover:bg-zinc-50 dark:hover:bg-zinc-700 transition">
                            <h4 class="font-semibold text-zinc-900 dark:text-zinc-100 text-left">What should I do about unauthorized access attempts?</h4>
                            <span id="faq-icon-4" class="text-2xl transition transform">+</span>
                        </button>
                        <div id="faq-content-4" class="hidden px-6 pb-4 border-t border-zinc-200 dark:border-zinc-700 text-sm text-zinc-600 dark:text-zinc-400">
                            <p>If you notice unauthorized access attempts with your plate:</p>
                            <ul class="list-disc list-inside mt-2 space-y-1">
                                <li>Check the timestamp and location of the attempt</li>
                                <li>Review the captured plate image</li>
                                <li><strong>Contact security immediately</strong> if it's not your vehicle</li>
                                <li>File a report with details and timestamps</li>
                                <li>Consider updating your plate number if your vehicle was stolen/damaged</li>
                            </ul>
                        </div>
                    </div>

                    <!-- FAQ Item 5 -->
                    <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl overflow-hidden bg-white dark:bg-zinc-800">
                        <button onclick="toggleFAQ(5)" class="w-full px-6 py-4 flex items-center justify-between hover:bg-zinc-50 dark:hover:bg-zinc-700 transition">
                            <h4 class="font-semibold text-zinc-900 dark:text-zinc-100 text-left">How do I update my vehicle information?</h4>
                            <span id="faq-icon-5" class="text-2xl transition transform">+</span>
                        </button>
                        <div id="faq-content-5" class="hidden px-6 pb-4 border-t border-zinc-200 dark:border-zinc-700 text-sm text-zinc-600 dark:text-zinc-400">
                            <p>To update your vehicle information:</p>
                            <ol class="list-decimal list-inside mt-2 space-y-1">
                                <li>Go to <strong>My Profile → Edit Profile</strong></li>
                                <li>Update the vehicle section (plate number, car model, color)</li>
                                <li>Submit your changes</li>
                                <li>Wait for admin approval (usually 2-3 days)</li>
                                <li>You'll receive confirmation when approved</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Troubleshooting Guide -->
        <div class="mt-8 border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 bg-white dark:bg-zinc-800">
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 mb-4">🔧 Troubleshooting Guide</h2>
            
            <div class="grid gap-6 md:grid-cols-2">
                <!-- Issue 1 -->
                <div>
                    <h3 class="font-semibold text-zinc-900 dark:text-zinc-100 mb-2">Can't login to my account</h3>
                    <ul class="text-sm text-zinc-600 dark:text-zinc-400 space-y-1 list-disc list-inside">
                        <li>Verify email and password are correct</li>
                        <li>Use "Forgot Password" to reset</li>
                        <li>Check if your account is active</li>
                        <li>Clear browser cache and cookies</li>
                        <li>Contact support if issue persists</li>
                    </ul>
                </div>

                <!-- Issue 2 -->
                <div>
                    <h3 class="font-semibold text-zinc-900 dark:text-zinc-100 mb-2">Not receiving notifications</h3>
                    <ul class="text-sm text-zinc-600 dark:text-zinc-400 space-y-1 list-disc list-inside">
                        <li>Check notification settings</li>
                        <li>Ensure email is verified</li>
                        <li>Check spam folder for emails</li>
                        <li>Refresh the page for updates</li>
                        <li>Contact support if emails aren't arriving</li>
                    </ul>
                </div>

                <!-- Issue 3 -->
                <div>
                    <h3 class="font-semibold text-zinc-900 dark:text-zinc-100 mb-2">Profile update rejected</h3>
                    <ul class="text-sm text-zinc-600 dark:text-zinc-400 space-y-1 list-disc list-inside">
                        <li>Check the rejection reason in your request</li>
                        <li>Verify all required fields are filled</li>
                        <li>Ensure plate number format is correct</li>
                        <li>Submit with corrected information</li>
                        <li>Contact support for clarification</li>
                    </ul>
                </div>

                <!-- Issue 4 -->
                <div>
                    <h3 class="font-semibold text-zinc-900 dark:text-zinc-100 mb-2">Gate access slow or not working</h3>
                    <ul class="text-sm text-zinc-600 dark:text-zinc-400 space-y-1 list-disc list-inside">
                        <li>Check internet connection</li>
                        <li>Make sure plate is clean/visible</li>
                        <li>Verify vehicle registration in system</li>
                        <li>Try again after 1-2 minutes</li>
                        <li>Report to security for manual verification</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Emergency Contact -->
        <div class="mt-6 p-6 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded-lg">
            <h3 class="text-lg font-bold text-red-900 dark:text-red-200 mb-2">🚨 Emergency?</h3>
            <p class="text-red-800 dark:text-red-300 mb-3">For security emergencies, call immediately:</p>
            <p class="text-2xl font-mono font-bold text-red-700 dark:text-red-400 mb-3">911 or +1 (555) 999-9999</p>
            <p class="text-sm text-red-800 dark:text-red-300">Available 24/7 for urgent security matters</p>
        </div>
    </div>

    <script>
        function toggleFAQ(id) {
            const content = document.getElementById(`faq-content-${id}`);
            const icon = document.getElementById(`faq-icon-${id}`);
            
            content.classList.toggle('hidden');
            
            // Rotate icon
            if (content.classList.contains('hidden')) {
                icon.textContent = '+';
            } else {
                icon.textContent = '−';
            }
        }

        function openChat() {
            alert('Chat feature will be implemented soon!');
            // TODO: Implement live chat
        }

        function callSupport() {
            window.location.href = 'tel:+15551234567';
        }
    </script>
</x-layouts.app>
