<footer class="footer footer-transparent d-print-none">
    <div class="container-xl">
        <div class="row text-center align-items-center flex-row-reverse">
            <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                    <li class="list-inline-item">
                        {{ __('Copyright') }} &copy; {{ date('Y') }}
                        <a href="{{ route('home') }}" class="link-secondary">{{ config('app.name') }}</a>.
                        {{ __('All rights reserved.') }}
                    </li>
                    <li class="list-inline-item">
                        <span class="text-secondary" rel="noopener">
                            v1.0.0
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
