<footer class="site-footer">
    <div class="container footer-grid">
        <div class="footer-brand">
            @include('partials.logo', ['variant' => 'full'])
            <p>One Passport, Endless Opportunities.</p>
            <div style="margin-top: 15px; display:flex; gap:15px;">
    <a href="https://facebook.com/tseaafrica" target="_blank" aria-label="TSEA on Facebook">
        <i class="fab fa-facebook-f"></i>
    </a>

    <a href="https://twitter.com/tseaafrica" target="_blank" aria-label="TSEA on X">
        <i class="fab fa-x-twitter"></i>
    </a>

    <a href="https://linkedin.com/company/tsea-africa" target="_blank" aria-label="TSEA on LinkedIn">
        <i class="fab fa-linkedin-in"></i>
    </a>

    <a href="https://instagram.com/tseaafrica" target="_blank" aria-label="TSEA on Instagram">
        <i class="fab fa-instagram"></i>
    </a>

    <a href="https://wa.me/254700000000" target="_blank" aria-label="TSEA on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <a href="https://youtube.com/@tseaafrica" target="_blank" aria-label="TSEA on YouTube">
        <i class="fab fa-youtube"></i>
    </a>
</div>

        </div>
        <div>
            <h2>Platform</h2>
            <a href="{{ route('passport') }}">Workforce Passport™</a>
            <a href="{{ route('eri') }}">ERI™</a>
            <a href="{{ route('intelligence') }}">Workforce Intelligence™</a>
        </div>
        <div>
            <h2>Stakeholders</h2>
            <a href="{{ route('programs') }}">Programs</a>
            <a href="{{ route('employers') }}">Employers</a>
            <a href="{{ route('institutions') }}">Institutions</a>
        </div>
        <div>
            <h2>Company</h2>
            <a href="{{ route('about') }}">About</a>
            <a href="{{ route('contact') }}">Contact</a>
            <a href="{{ route('passport.create') }}">Create Passport</a>
        </div>
        <form class="footer-newsletter">
            <label for="newsletter">Stay Updated</label>
            <div>
                <input id="newsletter" type="email" placeholder="Enter your email">
                <button class="btn btn-gold btn-sm" type="submit">Subscribe</button>
            </div>
        </form>
    </div>
    <div class="footer-bottom">© {{ date('Y') }} TSEA. All rights reserved.</div>
</footer>
