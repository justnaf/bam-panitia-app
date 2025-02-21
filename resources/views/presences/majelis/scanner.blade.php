<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('QR Scanner Kajian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('includes.taost')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div x-data="qrScanner()" class="p-4">
                        <h1 class="text-xl font-bold text-center">Presesni QR Code Scanner</h1>
                        <h1 class="text-xl font-bold mb-4 text-center">{{$kajian->name}}</h1>
                        <div id="qr-reader" class="mb-4"></div>
                        <div>
                            <input type="text" x-model="scannedResult" readonly class="border p-2 w-full" hidden>
                        </div>
                        <!-- Toggle Button for Switching Camera -->
                        <button @click="toggleCamera" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">
                            Switch Camera
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('addedScript')
    <script>
        function qrScanner() {
            return {
                scannedResult: ''
                , facingMode: "environment", // Default to back camera
                majelisId: @json($kajian), // Set the eventId
                html5QrCode: null, // Store the QR code scanner instance
                init() {
                    this.html5QrCode = new Html5Qrcode("qr-reader");
                    this.detectCameras();
                }
                , detectCameras() {
                    // Get all available video devices
                    navigator.mediaDevices.enumerateDevices().then(devices => {
                        const videoDevices = devices.filter(device => device.kind === "videoinput");

                        // Check if both front and back cameras are available
                        if (videoDevices.length > 0) {
                            const frontCamera = videoDevices.find(device => device.label.toLowerCase().includes("front"));
                            const backCamera = videoDevices.find(device => device.label.toLowerCase().includes("back"));

                            // Set facingMode based on available cameras
                            if (backCamera) {
                                this.facingMode = "environment"; // Use back camera if available
                            } else if (frontCamera) {
                                this.facingMode = "user"; // Use front camera if available
                            }
                        }

                        // Start the QR scanner with the detected camera
                        this.startScanner();
                    }).catch(err => {
                        console.error("Error detecting cameras:", err);
                    });
                }
                , startScanner() {
                    this.html5QrCode.start({
                            facingMode: this.facingMode
                        }, {
                            fps: 10
                            , qrbox: {
                                width: 250
                                , height: 250
                            }
                        }
                        , (decodedText, decodedResult) => {
                            this.scannedResult = decodedText;

                            const url = `/majelis-presecense/${this.majelisId.id}/${this.scannedResult}`;

                            window.location.href = url;

                            console.log(`Decoded text: ${decodedText}`);

                            this.html5QrCode.stop().then(() => {
                                console.log("QR scanner stopped.");
                            }).catch(err => {
                                console.error("Error stopping QR scanner:", err);
                            });
                        }
                    ).catch(err => {
                        console.error("Error starting QR scanner:", err);
                    });
                }
                , toggleCamera() {
                    // Toggle between "environment" (back camera) and "user" (front camera)
                    this.facingMode = (this.facingMode === "environment") ? "user" : "environment";

                    // Stop the current scanner and restart with the new facingMode
                    this.html5QrCode.stop().then(() => {
                        console.log("QR scanner stopped.");
                        this.startScanner(); // Restart with the new camera
                    }).catch(err => {
                        console.error("Error stopping QR scanner:", err);
                    });
                }
            };
        }

    </script>
    @endpush
</x-app-layout>
