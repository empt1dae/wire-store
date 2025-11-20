<?php
require_once __DIR__ . '/includes/header.php';
?>
<div class="about-main-center">
  <section class="section">
    <h1 class="about-title">About Wire</h1>
    <div class="about-desc">
     <p>Wire - это ваши футуристические ворота в мир компьютерной периферии. Мы верим в сочетание технологий и искусства, предлагая интерактивный и интуитивно понятный опыт покупок как для энтузиастов, так и для профессионалов.</p>
 Наша миссия состоит в том, чтобы сделать ваше рабочее пространство по-настоящему вашим, используя самые инновационные клавиатуры, сверхчувствительные мыши и аудиосистему с эффектом погружения — все это выбрано с учетом качества и производительности. Компания Wire, стремящаяся к исключительному дизайну и качеству обслуживания клиентов, стремится помочь вам найти инструменты, которые повысят вашу производительность.</p>
 <p> Ознакомьтесь с нашим тщательно отобранным каталогом, расширенным пользовательским интерфейсом и персонализированной поддержкой — Wire на каждом этапе работы меняет способ подключения к первоклассному оборудованию для ПК.</p>
    </div>
    <div class="about-team-section">
      <h2 class="about-team-title">Наша команда</h2>
      <div class="about-team-row">
        <div class="about-team-card">
          <div class="about-team-avatar about-team-avatar1">A</div>
          <div class="about-team-card-name">Алексей Вершинин</div>
          <div class="about-team-card-role">Founder &amp; Vision</div>
          <div class="about-team-card-desc">Создает инновационные решения и гарантирует, что проволока остается на переднем крае отрасли.</div>
        </div>
        <div class="about-team-card">
          <div class="about-team-avatar about-team-avatar2">J</div>
          <div class="about-team-card-name">Ксения Астахова</div>
          <div class="about-team-card-role">Customer Experience</div>
          <div class="about-team-card-desc">Следите за отзывами пользователей и создавайте комфортное и восхитительное путешествие по магазинам для всех.</div>
        </div>
        <div class="about-team-card">
          <div class="about-team-avatar about-team-avatar3">S</div>
          <div class="about-team-card-name">Мирон Селиванов</div>
          <div class="about-team-card-role">Tech Lead</div>
          <div class="about-team-card-desc">Инженер и любитель периферийных устройств Сэм обеспечивает бесперебойную и безопасную работу платформы для всех пользователей.</div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
<style>
.about-main-center { max-width: 840px; margin: 0 auto 42px auto; padding: 36px 4vw 36px 4vw; }
.about-title { font-size:2.1rem; font-weight:800; color:#1853A1; margin-bottom:16px; letter-spacing:-1px; text-align:center; }
.about-desc { font-size:1.13rem; color:#1e293b; margin-bottom:40px; line-height:1.7; text-align:center; }
.about-team-section { margin-top:24px; border-radius:18px; background:#fff; box-shadow:0 2px 14px 0 rgba(0,36,80,.05); padding:22px 15px 20px 15px; border:1px solid #e6effa; }
.about-team-title { font-size:1.24rem; letter-spacing:-.5px; color:#113; font-weight:700; margin-bottom:26px; text-align:center; }
.about-team-row { display:flex; flex-wrap:wrap; justify-content:center; gap:26px; }
.about-team-card { flex:0 0 200px; max-width:220px; background:#f4f8fd; border-radius:14px; box-shadow:0 1px 7px 0 rgba(36,60,110,.03); padding:20px 13px; display:flex; flex-direction:column; align-items:center; }
.about-team-avatar { width:54px; height:54px; border-radius:50%; background:#2563eb; color:#fff; display:flex; align-items:center; justify-content:center; font-size:2.2rem; font-weight:700; margin-bottom:10px; }
.about-team-avatar2{ background:#0369a1; } .about-team-avatar3{ background:#1ba37a; }
.about-team-card-name { font-weight:700; font-size:1.08rem; letter-spacing:-0.7px; color:#213778; }
.about-team-card-role { font-size:.97em; color:#2452A4; font-weight:500; margin-bottom:6px; }
.about-team-card-desc { color:#334155; font-size:.96em; text-align:center; }
@media (max-width:600px){ .about-team-row { flex-direction:column; align-items:center; gap:18px; } .about-team-section { padding:9px 3vw 11px 3vw; } .about-main-center { padding:14px 2vw 18px 2vw; } }
</style>
