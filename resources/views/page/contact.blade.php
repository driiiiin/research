<x-guest-layout>
    <nav class="w-full bg-[#14543A] shadow rounded-2xl mb-4">
        <div class="flex items-center h-16 px-6 space-x-8">
            <a href="{{ route('welcome') }}" class="text-white text-lg font-medium hover:underline">Home</a>
            <a href="{{ route('contact') }}" class="text-white text-lg font-medium hover:underline">Contact</a>
            <a href="{{ route('about') }}" class="text-white text-lg font-medium hover:underline">About</a>
        </div>
    </nav>
    <section class="relative max-w-7xl mx-auto mt-8 mb-8 bg-white rounded-lg shadow p-8 overflow-hidden">
        <!-- Contact header row with TTS button in upper right -->
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-[#14543A] mb-2">Contact</h2>
            <button id="tts-toggle"
                class="flex items-center gap-2 px-4 py-3 rounded-full shadow-lg bg-gradient-to-br from-[#14543A] to-[#17694a] text-white font-semibold text-base transition-all duration-200 hover:scale-105 hover:shadow-2xl focus:outline-none focus:ring-4 focus:ring-[#17694a]/30"
                style="backdrop-filter: blur(4px);"
                aria-label="Listen to Contact page"
            >
                <span class="sr-only">Toggle text-to-speech</span>
                <span id="tts-icon" class="flex items-center justify-center">
                    <i class="fa-solid fa-volume-up" style="font-size: 1.5rem;"></i>
                </span>
                <span id="tts-label" class="pr-1">Listen</span>
            </button>
        </div>
        <div id="contact-content" class="text-gray-700 space-y-2 leading-relaxed text-lg">
            <div>
                Health Policy Development and Planning Bureau - Health Research Division
            </div>
            <div>
                <a href="mailto:healthresearch@doh.gov.ph" class="text-indigo-600 hover:underline">healthresearch@doh.gov.ph</a>
            </div>
            <div>
                8651-7800 local 1326/1328
            </div>
        </div>
        <style>
            #tts-toggle {
                box-shadow: 0 8px 32px 0 rgba(20, 84, 58, 0.18);
            }
            #tts-toggle:active {
                transform: scale(0.97);
            }
            @media (max-width: 768px) {
                #tts-toggle {
                    right: 1.25rem;
                    bottom: 1.25rem;
                }
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ttsBtn = document.getElementById('tts-toggle');
                const ttsLabel = document.getElementById('tts-label');
                const ttsIcon = document.getElementById('tts-icon');
                const contactContent = document.getElementById('contact-content');
                let isSpeaking = false;
                let utterance;

                function getTextFromElement(element) {
                    let text = '';
                    element.childNodes.forEach(node => {
                        if (node.nodeType === Node.TEXT_NODE) {
                            text += node.textContent + ' ';
                        } else if (node.nodeType === Node.ELEMENT_NODE) {
                            text += getTextFromElement(node);
                        }
                    });
                    return text;
                }

                function resetTTSState() {
                    isSpeaking = false;
                    ttsLabel.textContent = 'Listen';
                    ttsIcon.innerHTML = `<i class="fa-solid fa-volume-up" style="font-size: 1.5rem;"></i>`;
                }

                ttsBtn.addEventListener('click', function () {
                    if (!isSpeaking) {
                        const text = getTextFromElement(contactContent).trim();
                        console.log('TTS text:', text); // Debug log
                        if ('speechSynthesis' in window) {
                            window.speechSynthesis.cancel(); // Prevent overlap
                            utterance = new window.SpeechSynthesisUtterance(text);
                            utterance.onend = function () {
                                resetTTSState();
                            };
                            utterance.onerror = function (e) {
                                console.error('TTS error:', e);
                                resetTTSState();
                            };
                            window.speechSynthesis.speak(utterance);
                            isSpeaking = true;
                            ttsLabel.textContent = 'Stop';
                            ttsIcon.innerHTML = `<i class="fa-solid fa-volume-xmark" style="font-size: 1.5rem;"></i>`;
                        } else {
                            alert('Sorry, your browser does not support text-to-speech.');
                        }
                    } else {
                        if ('speechSynthesis' in window) {
                            window.speechSynthesis.cancel();
                        }
                        resetTTSState();
                    }
                });
            });
        </script>
    </section>
</x-guest-layout>
