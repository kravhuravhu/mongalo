<button class="scroll-top" id="scrollTopBtn" aria-label="Scroll to top">
    <i class="fas fa-arrow-up" aria-hidden="true"></i>
</button>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('scrollTopBtn');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 400) {
            btn.classList.add('scroll-top--visible');
        } else {
            btn.classList.remove('scroll-top--visible');
        }
    }, { passive: true });
    
    btn.addEventListener('click', function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});
</script>
@endpush