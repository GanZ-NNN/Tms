<footer class="footer">
    <div class="container text-center py-3">
        <p>&copy; {{ date('Y') }} TMS - Training Management System. All Rights Reserved.</p>
    </div>
</footer>

<!-- JS Libraries -->
<!-- <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<!-- Additional JS per page -->
@stack('scripts')
