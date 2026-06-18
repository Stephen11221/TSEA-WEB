<footer class="site-footer">
    <div class="container footer-grid">
        <div class="footer-brand">
            @include('partials.logo', ['variant' => 'full'])

            <p>One Passport, Endless Opportunities.</p>

            <div class="social-links">
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
            <div class="newsletter-box">
                <input id="newsletter" type="email" placeholder="Enter your email">
                <button class="btn btn-gold btn-sm" type="submit">Subscribe</button>
            </div>
        </form>
    </div>

    <div class="footer-bottom">
        © {{ date('Y') }} TSEA. All rights reserved.
    </div>
</footer>

<style>
.site-footer{
    background:#0B1D33; /* Primary Corporate Navy */
    color:#d1d5db;
    padding:60px 0 20px;
}

.footer-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:30px;
}

.site-footer h2{
    color:#fff;
    margin-bottom:15px;
    font-size:18px;
}

.site-footer p,
.site-footer label,
.site-footer a{
    color:#d1d5db;
}

.site-footer a{
    display:block;
    margin-bottom:10px;
    text-decoration:none;
    transition:all .3s ease;
}

.site-footer a:hover{
    color:#fff;
}

.social-links{
    margin-top:15px;
    display:flex;
    gap:15px;
}

.social-links a{
    margin:0;
}

.social-links .fab{
    font-size:20px;
    color:#d1d5db;
    transition:all .3s ease;
}

.social-links .fab:hover{
    color:#fff;
    transform:translateY(-2px);
}

.footer-newsletter label{
    display:block;
    margin-bottom:10px;
    font-weight:600;
}

.newsletter-box{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.newsletter-box input{
    flex:1;
    min-width:180px;
    padding:10px 12px;
    border:none;
    border-radius:6px;
    outline:none;
}

.footer-bottom{
    text-align:center;
    margin-top:40px;
    padding-top:20px;
    border-top:1px solid rgba(255,255,255,.15);
    color:#9ca3af;
}

.btn-gold{
    background:#FFC107; /* Primary Gold */
    color:#0B1D33; /* Primary Corporate Navy */
    border:none;
    padding:10px 18px;
    border-radius:6px;
    cursor:pointer;
    font-weight:600;
}

.btn-gold:hover{
    background:#E6B000; /* Slightly darker gold on hover */
}
</style>