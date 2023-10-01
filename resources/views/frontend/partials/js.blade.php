<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('frontend-assets/lib/wow/wow.min.js') }}"></script>
<script src="{{ asset('frontend-assets/lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('frontend-assets/lib/waypoints/waypoints.min.js') }}"></script>
<script src="{{ asset('frontend-assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>
<script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js'></script>
<script src="{{ asset('frontend-assets/js/main.js') }}"></script>
@livewireScripts
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-livewire-alert::scripts />
@stack('scripts')
