<footer class="site-footer">
    <div class="site-footer__inner">
        <p class="footer-text">Purely fictional, website is built for demo ;)</p>

        <a href="{{ route('home') }}" class="logo logo--orange">mijusan</a>

        <div class="footer-icons">
            <a href="{{ route('rickroll') }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><x-icon name="facebook" :size="28" /></a>
            <a href="{{ route('rickroll') }}" target="_blank" rel="noopener noreferrer" aria-label="Twitter"><x-icon name="twitter" :size="28" /></a>
            <a href="{{ route('rickroll') }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><x-icon name="instagram" :size="28" /></a>
            <a href="{{ route('rickroll') }}" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><x-icon name="youtube" :size="28" /></a>
        </div>
    </div>
</footer>
