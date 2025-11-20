</main>
    <footer class="site-footer custom-footer">
      <div class="footer-flex">
        <div class="footer-col left">
          <div class="footer-logo-row">
            <span class="footer-logo-box">W</span>
            <span class="footer-brand-name">Wire</span>
          </div>
          <div class="footer-desc">Ваша цифровая вселенная компьютерной периферии премиум-класса. <br>
Качественные клавиатуры, мыши, наушники и аксессуары для современного рабочего пространства.</div>
         
        </div>
        <div class="footer-col middle">
          <div class="footer-label">QUICK LINKS</div>
          <div class="footer-links-v">
            <a href="catalog.php">Catalog</a>
            <a href="about.php">About Us</a>
            <a href="contact.php">Contact</a>
            
          </div>
        </div>
        <div class="footer-col right">
          <div class="footer-label">CONTACT</div>
          <div class="footer-contact-list">
            <div><i class="fa-regular fa-envelope"></i> info@wire.com</div>
            <div><i class="fa-solid fa-phone"></i> +7 (999) 123-45-67</div>
            <div><i class="fa-solid fa-location-dot"></i> Россия, г. Москва, ул. Лесная, д. 18</div>
          </div>
        </div>
      </div>
    </footer>
    <style>
      html, body { height: 100%; }
      body { min-height: 100vh; display: flex; flex-direction: column; }
      .site-header { flex-shrink: 0; }
      main.container, .container.main { flex: 1 0 auto; width:100%; }
      .custom-footer.site-footer { flex-shrink: 0; background: #f7f9fb; border-top: 1px solid #e6effa; padding: 0; font-size: 15px; margin-top:auto; }
      .footer-flex { max-width: 1200px; margin: 0 auto; padding: 38px 22px; display: flex; gap: 40px; flex-wrap:wrap; }
      .footer-col { flex: 1 1 200px; min-width: 200px; display: flex; flex-direction: column; }
      .footer-logo-row { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
      .footer-logo-box { display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; font-size:21px; background:#2563eb; color:#fff; border-radius:7px; font-weight:700; letter-spacing:-1.3px; }
      .footer-brand-name { font-size:1.35rem; font-weight:700; color:#222; }
      .footer-desc { color:#4b5563; line-height:1.6; font-size:15px; margin-bottom:18px; }
      .footer-icons { display: flex; gap: 13px; margin-top:10px;}
      .footer-icon { color: #9ca3af; font-size:18px; text-decoration:none; transition:color .18s; }
      .footer-icon:hover { color: #2563eb; }
      .footer-label { font-size: 15px; color:#374151; font-weight:700; letter-spacing:0.5px; margin-bottom:15px; }
      .footer-links-v { display:flex; flex-direction:column; gap:6px; }
      .footer-links-v a { color:#325491; text-decoration:none; transition:color .15s; }
      .footer-links-v a:hover { color:#2563eb; }
      .footer-contact-list { display:flex; flex-direction:column; gap:8px; color:#4b5563; }
      .footer-contact-list i { margin-right:8px; color:#2563eb; }
      @media (max-width:900px) { .footer-flex { flex-wrap:wrap; gap: 16px; padding: 32px 7vw; } }
      @media (max-width:600px) {
        .footer-flex { flex-direction:column; gap:32px; padding:28px 2vw; }
        .footer-col { min-width:0; }
      }
    </style>
  </body>
</html>