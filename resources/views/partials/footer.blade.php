<footer class="site-footer">
    <div class="container footer-grid">
        <div class="footer-brand">
            @include('partials.logo', ['variant' => 'full'])
            <p>One Passport, Endless Opportunities.</p>
            <div style="margin-top: 15px;">
                <a href="#" aria-label="TSEA on Twitter"><i class="fas fa-twitter"></i></a>
                <a href="#" aria-label="TSEA on LinkedIn"><i class="fas fa-linkedin"></i></a>
                <a href="#" aria-label="TSEA on Facebook"><i class="fas fa-facebook"></i></a>
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
