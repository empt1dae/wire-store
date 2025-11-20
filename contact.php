<?php
require_once __DIR__ . '/includes/header.php';
?>
<div class="contact-wrap-main">
  <h1 class="contact-title">Contact Us</h1>
  <div class="contact-desc">У вас есть вопросы? Мы будем рады получить от вас ответы. Отправьте нам сообщение, и мы ответим как можно скорее.</div>
  <div class="contact-row">
    <aside class="contact-aside">
      <div class="contact-section-title">Get in Touch</div>
      <div class="contact-info-list">
        <div class="contact-info-block">
          <i class="fa-regular fa-envelope"></i>
          <div>
            <strong>Email</strong><br>
            info@wire.com<br>
            support@wire.com
          </div>
        </div>
        <div class="contact-info-block">
          <i class="fa-solid fa-phone"></i>
          <div>
            <strong>Phone</strong><br>
            +7 (999) 123-45-67
            
          </div>
        </div>
        <div class="contact-info-block">
          <i class="fa-solid fa-location-dot"></i>
          <div>
            <strong>Address</strong><br>
            Россия, г. Москва<br>
            ул. Лесная, д. 18
          </div>
        </div>
        <div class="contact-info-block">
          <i class="fa-regular fa-clock"></i>
          <div>
            <strong>Bussines Hours</strong><br>
            Понедельник – Пятница: 9:00  – 18:00<br>
            Суббота: 10:00 – 16:00 <br>
            Воскресенье: Закрыто
          </div>
        </div>
      </div>
    </aside>
    <section class="contact-form-card">
      <form class="contact-form" id="contactForm">
        <h2 class="contact-form-title">Отправьте сообщение</h2>
        <div class="contact-form-row">
          <div class="form-field">
            <label for="contact_name">Ваше имя</label>
            <input type="text" id="contact_name" name="name" placeholder="Ваше имя">
          </div>
          <div class="form-field">
            <label for="contact_email">Email Address</label>
            <input type="email" id="contact_email" name="email" placeholder="your.email@example.com">
          </div>
        </div>
        <div class="form-field">
          <label for="contact_subject">Subject</label>
          <select id="contact_subject" name="subject">
            <option value="" disabled selected>Select a subject</option>
            <option>Order Inquiry</option>
            <option>Account Support</option>
            <option>Product Question</option>
            <option>Other</option>
          </select>
        </div>
        <div class="form-field">
          <label for="contact_message">Сообщение</label>
          <textarea id="contact_message" name="message" rows="5" placeholder="Расскажите нам, как мы можем вам помочь..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary contact-form-btn"><i class="fa-regular fa-paper-plane"></i> Send Message</button>
      </form>
    </section>
  </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
<script type="module">
  import { showToast } from '<?php echo e(base_url('assets/js/main.js')); ?>';
  document.getElementById('contactForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    showToast('Message sent successfully! We will get back to you soon.', 'success', 4000);
    this.reset();
  });
</script>
<style>
.contact-wrap-main {
  max-width: 1150px;
  margin: 0 auto 40px auto;
  padding: 32px 0 0 0;
}
.contact-title {
  text-align:center; font-size:2.2rem; margin-bottom:8px; font-weight:800; letter-spacing:-1px;
}
.contact-desc {
  text-align:center; color:#234372; font-size:1.16rem; margin-bottom:40px;
}
.contact-row {
  display: flex;
  gap: 34px;
  flex-wrap: wrap;
  justify-content: center;
  align-items: flex-start;
}
.contact-aside {
  min-width: 260px;
  max-width:360px;
  flex: 1 1 230px;
  font-size: 1.045rem;
  padding-right:28px;
}
.contact-section-title {
  font-size: 1.37rem;
  font-weight:700;
  margin-bottom:22px;
  letter-spacing:-.6px;
}
.contact-info-list {
  display: flex; flex-direction:column; gap:25px;
}
.contact-info-block {
  display: flex; align-items: flex-start; gap:17px; font-size:1em;
  color: #223;
}
.contact-info-block i {
  font-size: 1.45em; color: #2563eb; margin-top:3px;
}
.contact-form-card {
  flex: 2 1 420px;
  background: #fff;
  border-radius:18px;
  box-shadow: 0 2.5px 16px 0 rgba(0,36,80,.07);
  border: 1px solid #e6effa;
  padding: 36px 38px 30px 38px;
  margin-bottom:30px;
  min-width:320px;
  max-width: min(97vw, 640px);
}
.contact-form-title {
  font-size: 1.28rem;
  font-weight:700;
  margin-bottom:26px;
  letter-spacing:-.5px;
}
.contact-form {
  display: flex; flex-direction: column; gap: 22px;
}
.contact-form-row {
  display: flex; gap: 16px; flex-wrap:wrap;
}
.form-field {
  flex:1 1 200px;
  display: flex; flex-direction: column; gap: 7px;
  min-width: 100px;
}
input[type=\"text\"], input[type=\"email\"], select, textarea {
  border:1px solid #d1d5db; border-radius:8px;
  font-size:1em; padding:10px 12px; font-family:inherit;
  background:#f8fafc; color:#173366;
  transition:border-color .15s, box-shadow .15s;
}
input:focus, select:focus, textarea:focus {
  border-color:#2563eb; outline:none; background:#f0f6fd;
}
textarea { min-height:94px; resize:vertical; }
.contact-form-btn {
  display: flex; align-items: center; justify-content: center;
  width: 100%; font-weight:600; font-size:1.08rem; letter-spacing:-.3px;
  margin-top: 10px;
  gap:10px;
}
@media (max-width:900px) {
  .contact-row { flex-direction:column; gap:38px; }
  .contact-aside, .contact-form-card { max-width: none; padding-right:0; }
}
@media (max-width:600px) {
  .contact-form-card { padding: 16px 5vw 18px 5vw; }
  .contact-title { font-size:1.43rem; }
  .contact-section-title { font-size:1rem; }
}
</style>