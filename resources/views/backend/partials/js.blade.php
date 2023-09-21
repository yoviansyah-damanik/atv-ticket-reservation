<script src="{{ asset('backend-assets/libs/apexcharts/dist/apexcharts.min.js?1684106062') }}" defer></script>
<script src="{{ asset('backend-assets/libs/jsvectormap/dist/js/jsvectormap.min.js?1684106062') }}" defer></script>
<script src="{{ asset('backend-assets/libs/jsvectormap/dist/maps/world.js?1684106062') }}" defer></script>
<!-- Tabler Core -->
<script src="{{ asset('backend-assets/js/tabler.min.js?1684106062') }}" defer></script>
<script src="{{ asset('backend-assets/js/demo.min.js?1684106062') }}" defer></script>
@livewireScripts
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-livewire-alert::scripts />
@stack('scripts')
<script type="text/javascript">
    document.addEventListener('modal-close', () => {
        console.log('Reset Modal')
        // let modal = new Modal()
        // modal._hideModal()
        // document.querySelector('.modal').modal()
    });
</script>
