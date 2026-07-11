<?php
// BLZ PREDICTOR — PHP Version
header("Content-Type: text/html; charset=UTF-8");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>BLZ PREDICTOR</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Orbitron:wght@700;900&family=Grandstander:ital,wght@0,100..900;1,100..900&family=Poppins:wght@400;500;600;700;800;900&family=Nunito:wght@500;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * { margin:0;padding:0;box-sizing:border-box;font-family:'Grandstander','Poppins','Nunito','Inter',sans-serif;-webkit-tap-highlight-color:transparent; }
        html,body { height:100%;width:100%;background-color:#dadddf;display:flex;justify-content:center;overflow:hidden; }
        .app-container { width:100%;max-width:480px;height:100%;height:100dvh;background:#e2e4e9;position:relative;display:flex;flex-direction:column;box-shadow:0 0 25px rgba(0,0,0,0.15);overflow:hidden; }
        @media (max-width:480px) { .app-container { max-width:100%;box-shadow:none; } }

        /* ============ SCREEN 0: FIRST SCREEN — exact Frist.html UI ============ */
        #screen-first {
            position:absolute;inset:0;z-index:99999;
            display:flex;flex-direction:column;background:#fff;
            transition:opacity 0.5s ease,transform 0.5s ease;
            font-family:'Inter',sans-serif;
        }
        #screen-first.hide { opacity:0;transform:scale(0.95);pointer-events:none; }

        /* gradient bg */
        .sf-gradient-bg {
            position:absolute;top:0;left:0;width:100%;height:65%;
            background:linear-gradient(180deg,#b0a3ff 0%,#ffffff 100%);z-index:1;
        }
        /* image area */
        .sf-image-container {
            position:relative;z-index:2;flex:1;min-height:0;
            display:flex;justify-content:center;align-items:center;padding-top:10vh;
        }
        .sf-image-container img {
            max-height:100%;max-width:80%;object-fit:contain;
            -webkit-mask-image:linear-gradient(to bottom,black 65%,transparent 100%);
            mask-image:linear-gradient(to bottom,black 65%,transparent 100%);
        }
        /* content section */
        .sf-content {
            position:relative;z-index:3;background:#fff;
            padding:2vh 25px 3vh;text-align:center;flex-shrink:0;
        }
        .sf-title {
            font-size:clamp(22px,5.5vw,26px);font-weight:600;color:#000;
            line-height:1.3;margin-bottom:2vh;font-family:'Inter',sans-serif;
        }
        .sf-btn {
            width:100%;padding:16px;border:none;border-radius:30px;
            background:linear-gradient(90deg,#9b81ff 0%,#e6dfff 100%);
            color:#fff;font-size:18px;font-weight:600;
            cursor:pointer;margin-bottom:5px;transition:all 0.2s ease;
            font-family:'Inter',sans-serif;
        }
        .sf-btn:active { transform:scale(0.96); }
        .sf-btn:disabled { opacity:0.7;cursor:not-allowed; }
        .sf-err-space { height:20px;margin-bottom:5px; }
        .sf-err { color:#d93025;font-size:12px;font-weight:500;display:none; }
        .sf-checkbox-area {
            display:flex;align-items:center;justify-content:center;
            gap:10px;margin-bottom:1.5vh;
        }
        .sf-checkbox-area input[type="checkbox"] { width:18px;height:18px;cursor:pointer;accent-color:#9b81ff; }
        .sf-checkbox-area label { font-size:13px;font-weight:600;color:#000;cursor:pointer; }
        .sf-subtext { font-size:11px;color:#666;line-height:1.4;margin-bottom:3vh; }
        .sf-footer { display:flex;justify-content:space-between;padding:0 10px; }
        .sf-footer a { text-decoration:none;color:#000;font-size:12px;font-weight:700; }

        /* ============ SCREEN 1: LANDING PAGE (device key check) ============ */
        #landing-page {
            position:absolute;inset:0;z-index:9998;
            background:linear-gradient(180deg,#E2D7FF 0%,#FFFFFF 35%);
            display:none;flex-direction:column;overflow:hidden;
            transition:opacity 0.5s ease,transform 0.5s ease;
        }
        #landing-page.show { display:flex; }
        #landing-page.hide-login { opacity:0;transform:scale(0.95);pointer-events:none; }
        .landing-image-container { width:100%;height:42vh;display:flex;justify-content:center;align-items:flex-end;padding:10px; }
        .landing-image { max-width:90%;max-height:100%;object-fit:contain;animation:floatUD 4s ease-in-out infinite;filter:drop-shadow(0px 10px 20px rgba(0,0,0,0.1)); }
        .anim-fade-up { opacity:0;transform:translateY(20px);animation:fadeUp 0.6s ease forwards; }
        .delay-1 { animation-delay:0.1s; } .delay-2 { animation-delay:0.2s; } .delay-3 { animation-delay:0.3s; } .delay-4 { animation-delay:0.4s; } .delay-5 { animation-delay:0.5s; }
        @keyframes fadeUp { to { opacity:1;transform:translateY(0); } }
        .landing-content-area { flex:1;display:flex;flex-direction:column;align-items:center;padding:10px 20px 20px;background:#FFFFFF; }
        .landing-title { font-size:22px;font-weight:900;color:#000000;text-align:center;line-height:1.15;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px;font-family:'Poppins',sans-serif; }
        .landing-subtitle { font-size:11px;font-weight:500;color:#4B5563;text-align:center;line-height:1.4;margin-bottom:20px;font-family:'Poppins',sans-serif; }
        .landing-cards-row { display:flex;gap:10px;width:100%;margin-bottom:20px; }
        .l-card { flex:1;border-radius:14px;padding:12px 10px;display:flex;align-items:center;gap:8px;text-decoration:none;cursor:pointer;transition:transform 0.2s; }
        .l-card:active { transform:scale(0.96); }
        .l-card.join { background-color:#F6F1FF;border:1px solid #D8CCF8; }
        .l-card.support { background-color:#FFFFFF;border:1px solid #E5E7EB;box-shadow:0 4px 10px rgba(0,0,0,0.02); }
        .l-card-icon { width:28px;height:28px;display:flex;justify-content:center;align-items:center;flex-shrink:0; }
        .l-card-text { display:flex;flex-direction:column; }
        .l-card-text strong { font-size:12px;font-weight:800;color:#000000;line-height:1.1;margin-bottom:3px;font-family:'Poppins',sans-serif; }
        .l-card-text span { font-size:8.5px;color:#888;font-weight:500;line-height:1.2;font-family:'Poppins',sans-serif; }
        .landing-main-btn { width:100%;height:48px;border-radius:24px;background:linear-gradient(90deg,#A78BFA 0%,#C4B5FD 100%);border:none;color:#FFFFFF;font-size:16px;font-weight:800;display:flex;justify-content:center;align-items:center;gap:8px;box-shadow:0 8px 18px rgba(167,139,250,0.4);cursor:pointer;transition:all 0.2s;margin-bottom:20px;font-family:'Poppins',sans-serif; }
        .landing-main-btn:active { transform:scale(0.97);box-shadow:0 4px 10px rgba(167,139,250,0.3); }
        .device-id-display { font-size:12px;color:#000000;font-weight:700;display:flex;align-items:center;gap:6px;background:#F9F5FF;border:1px solid #E9D5FF;border-radius:20px;padding:8px 14px;margin-bottom:16px;font-family:'Poppins',sans-serif; }
        .copy-icon-btn { width:22px;height:22px;display:flex;align-items:center;justify-content:center;background:#EDE9FE;border-radius:6px;cursor:pointer;flex-shrink:0; }
        .landing-footer { display:flex;gap:16px;align-items:center;justify-content:center;flex-wrap:wrap; }
        .landing-footer div { display:flex;align-items:center;gap:4px;font-size:9.5px;font-weight:600;color:#6B7280;cursor:pointer;font-family:'Poppins',sans-serif; }

        /* ============ SERVER DOWN ============ */
        #server-down-overlay { display:none;position:fixed;inset:0;z-index:99999;background:rgba(0,0,0,0.85);justify-content:center;align-items:center; }
        #server-down-overlay.active { display:flex; }
        .server-down-box { background:#1a1a2e;border:2px solid #EF4444;border-radius:20px;padding:32px 24px;text-align:center;max-width:300px;width:90%; }
        .server-down-box .icon { font-size:48px;margin-bottom:12px; }
        .server-down-box h2 { color:#EF4444;font-size:20px;font-weight:800;margin-bottom:8px; }
        .server-down-box p { color:#9CA3AF;font-size:13px;line-height:1.5; }

        /* ============ LOADING OVERLAY ============ */
        #loading-overlay { display:none;position:fixed;inset:0;z-index:99995;background:rgba(255,255,255,0.9);justify-content:center;align-items:center;flex-direction:column;gap:16px; }
        #loading-overlay.show { display:flex; }
        .loading-spinner { width:44px;height:44px;border:4px solid #E9D5FF;border-top:4px solid #9b81ff;border-radius:50%;animation:spin 0.8s linear infinite; }
        @keyframes spin { to{transform:rotate(360deg)} }
        #loading-text { font-size:14px;font-weight:700;color:#555;font-family:'Poppins',sans-serif; }

        /* ============ TOAST ============ */
        #toast { position:fixed;bottom:80px;left:50%;transform:translateX(-50%) translateY(20px);background:#333;color:#fff;padding:10px 20px;border-radius:20px;font-size:13px;font-weight:600;opacity:0;pointer-events:none;transition:all 0.3s;z-index:99998;white-space:nowrap;font-family:'Poppins',sans-serif; }
        #toast.show { opacity:1;transform:translateX(-50%) translateY(0); }

        /* ============ MAIN APP ============ */
        :root { --primary:#8B78E6;--dark:#7966D2;--item-bg:#F7F7F9;--nav-fill-color:var(--primary);--nav-stroke-color:#FFFFFF;--bg-color:#e2e4e9;--card-bg:#ffffff; }
        .page { position:absolute;top:0;left:0;width:100%;height:100%;display:flex;flex-direction:column;transition:transform 0.35s cubic-bezier(0.4,0,0.2,1),opacity 0.35s ease;will-change:transform; }
        #main-page { transform:translateX(0);z-index:1;visibility:hidden; }
        #main-page.auth-ready { visibility:visible; }
        #main-page.slide-out { transform:translateX(-100%); }
        #webview-page { transform:translateX(100%);z-index:2;background:#ffffff; }
        #webview-page.slide-in { transform:translateX(0); }
        .content-area { flex:1;overflow-y:auto;overflow-x:hidden;scrollbar-width:none;position:relative; }
        .content-area::-webkit-scrollbar { display:none; }
        .tab-panel { display:none;width:100%;min-height:100%; }
        .tab-panel.active { display:block; }

        /* BOTTOM NAV */
        .bottom-nav { display:flex;justify-content:space-around;align-items:center;background-color:#FFFFFF;border-top:1.5px solid #F0EEF8;padding:8px 0 calc(8px + env(safe-area-inset-bottom));flex-shrink:0;box-shadow:0 -4px 16px rgba(139,120,230,0.08);z-index:100; }
        .nav-item { display:flex;flex-direction:column;align-items:center;gap:4px;cursor:pointer;padding:4px 18px;border-radius:14px;transition:background 0.18s;user-select:none; }
        .nav-item:active { background:rgba(139,120,230,0.08); }
        .nav-text { font-size:11px;font-weight:700;color:#AAAAAA;letter-spacing:0.2px;transition:color 0.2s; }
        .nav-icon-wrapper { display:flex;align-items:center;justify-content:center; }
        .nav-item:not(.active) svg [fill="#957DEC"],.nav-item:not(.active) svg [fill="#1c1c1e"] { fill:#CCCCCC; }
        .nav-item:not(.active) svg [stroke="white"] { stroke:var(--item-bg); }
        .nav-item:not(.active) svg circle[fill="white"],.nav-item:not(.active) svg rect[fill="white"] { fill:var(--item-bg); }
        .nav-item.active .nav-text { color:var(--primary); }
        .nav-item.active svg [fill="#957DEC"],.nav-item.active svg [fill="#1c1c1e"] { fill:var(--nav-fill-color); }
        .nav-item.active svg [stroke="white"] { stroke:var(--nav-stroke-color); }
        .nav-item.active svg circle[fill="white"],.nav-item.active svg rect[fill="white"] { fill:var(--nav-stroke-color); }

        /* TAB HOME */
        #tab-home { background-color:var(--bg-color);padding:20px 15px; }
        .home-header { display:flex;align-items:center;margin-bottom:20px;padding-left:5px; }
        .avatar { width:45px;height:45px;background-color:#b98175;color:white;border-radius:50%;display:flex;justify-content:center;align-items:center;font-weight:600;font-size:16px;margin-right:12px;overflow:hidden;flex-shrink:0; }
        .avatar img { width:100%;height:100%;object-fit:cover;border-radius:50%; }
        .user-info { display:flex;flex-direction:column; }
        .welcome-text { font-size:11px;color:#797b86;margin-bottom:2px; }
        .user-name { font-size:15px;font-weight:700;color:#333145;text-transform:uppercase;letter-spacing:0.5px; }
        .main-card { background-color:var(--card-bg);border-radius:24px;padding:30px 20px;display:flex;flex-direction:column;align-items:center;text-align:center;box-shadow:0 4px 15px rgba(0,0,0,0.03);margin-bottom:15px; }
        .logo-wrapper { position:relative;width:160px;height:95px;border-radius:10px;overflow:hidden;display:flex;justify-content:center;align-items:center;margin-bottom:20px;background:#f0f0f0; }
        .logo-wrapper::before { content:'';position:absolute;width:200%;height:200%;background:conic-gradient(from 0deg,transparent 75%,#00d2ff 100%);animation:rotate-snake 2s linear infinite; }
        .logo-wrapper img { width:calc(100% - 5px);height:calc(100% - 5px);object-fit:contain;border-radius:7px;position:relative;z-index:1;background-color:white; }
        @keyframes rotate-snake { 0%{transform:rotate(0deg)} 100%{transform:rotate(360deg)} }
        .main-card h1 { color:#333145;font-size:22px;font-weight:700;margin-bottom:12px; }
        .main-card p { color:#797b86;font-size:13px;line-height:1.5;margin-bottom:20px;padding:0 10px; }
        .badge { background-color:#578c6b;color:white;padding:8px 16px;border-radius:20px;font-size:12px;font-weight:700;display:flex;align-items:center;gap:6px;letter-spacing:0.5px; }
        .badge svg { width:14px;height:14px;fill:currentColor; }
        .grid-container { display:grid;grid-template-columns:1fr 1fr;gap:15px; }
        .grid-card { background-color:var(--card-bg);border-radius:20px;padding:20px 15px;box-shadow:0 4px 15px rgba(0,0,0,0.03);display:flex;flex-direction:column;align-items:flex-start;cursor:pointer;transition:transform 0.15s; }
        .grid-card:active { transform:scale(0.97); }
        .grid-card svg { width:24px;height:24px;fill:#4a456c;margin-bottom:15px; }
        .grid-card h3 { color:#333145;font-size:15px;font-weight:700;margin-bottom:6px; }
        .grid-card p { color:#797b86;font-size:11px;line-height:1.4; }

        /* TAB PLAN */
        #tab-plan { background:#efefef;display:none;flex-direction:column;min-height:100%; }
        #tab-plan.active { display:flex; }
        .plan-header { padding:20px;display:flex;align-items:center;gap:12px; }
        .plan-profile-icon { width:45px;height:45px;background-color:#ae756c;color:white;border-radius:50%;display:flex;justify-content:center;align-items:center;font-weight:800;font-size:16px;border:2px solid #ce9e96;overflow:hidden;flex-shrink:0; }
        .plan-profile-icon img { width:100%;height:100%;object-fit:cover;border-radius:50%; }
        .plan-profile-text { display:flex;flex-direction:column; }
        .plan-welcome { font-size:11px;color:#8c8f94;font-weight:700; }
        .plan-name { font-size:15px;color:#2c2f33;font-weight:900;text-transform:uppercase; }
        .plan-main { flex:1;display:flex;flex-direction:column;align-items:center;padding:20px 0;margin-top:4vh; }
        .animated-logo-wrapper { position:relative;width:160px;height:90px;margin-bottom:25px;border-radius:14px;display:flex;justify-content:center;align-items:center;overflow:hidden; }
        .animated-logo-wrapper::before { content:'';position:absolute;width:250px;height:250px;background:conic-gradient(transparent,transparent,transparent,#00d2ff);animation:rotateBorder 2.5s linear infinite; }
        .animated-logo-wrapper::after { content:'';position:absolute;inset:3px;background:#efefef;border-radius:12px; }
        .animated-logo-wrapper img { position:relative;z-index:10;width:calc(100% - 6px);height:calc(100% - 6px);object-fit:cover;border-radius:11px; }
        @keyframes rotateBorder { 0%{transform:rotate(0deg)} 100%{transform:rotate(360deg)} }
        .plan-title { font-size:22px;font-weight:900;color:#4c4664;margin-bottom:10px; }
        .plan-subtitle { font-size:12px;color:#7b7e85;font-weight:700;text-align:center;padding:0 30px;line-height:1.5;margin-bottom:40px; }
        .plan-loading { font-size:14px;color:#8c8f94;font-weight:700;margin-top:20px; }
        .plans-wrapper { width:100%;display:none;flex-direction:column; }
        .upgrade-label { font-size:11px;color:#555;font-weight:900;padding-left:20px;margin-bottom:10px; }
        .carousel { display:flex;overflow-x:auto;scroll-snap-type:x mandatory;gap:15px;padding:0 20px 20px 20px;scrollbar-width:none; }
        .carousel::-webkit-scrollbar { display:none; }
        .plan-card { background-color:#fcfcfc;min-width:85%;border-radius:20px;padding:20px;box-shadow:0 4px 15px rgba(0,0,0,0.04);scroll-snap-align:center; }
        .plan-price-title { font-size:18px;font-weight:900;color:#3b3a4a;margin-bottom:20px;display:flex;justify-content:space-between; }
        .discount-badge { font-size:10px;color:#3b3a4a;font-weight:900; }
        .features-grid { display:grid;grid-template-columns:1fr 1fr;gap:12px 10px; }
        .feature-item { display:flex;align-items:flex-start;gap:8px;font-size:11px;font-weight:800;color:#52535a;text-transform:uppercase; }
        .feature-icon { color:#b05c5c;font-size:10px;margin-top:2px; }
        .bottom-actions { padding:20px;display:flex;flex-direction:column;gap:15px;margin-top:auto;margin-bottom:10px; }
        .button-row { display:flex;gap:10px; }
        .btn-primary { flex:1;background-color:#4b446a;color:white;border:none;padding:16px;border-radius:12px;font-size:14px;font-weight:800;cursor:pointer;transition:all 0.3s;font-family:'Grandstander','Nunito',sans-serif; }
        .btn-disabled { background-color:#a49ea7;pointer-events:none; }
        .btn-status { background-color:#c0a47f;color:white;border:none;padding:16px;border-radius:12px;font-size:14px;font-weight:800;cursor:pointer;display:none;white-space:nowrap;font-family:'Grandstander','Nunito',sans-serif; }

        /* TAB PROFILE */
        #tab-profile { background-color:#dadddf;padding:20px; }
        .profile-card-box { background-color:#f6f7f6;border-radius:20px;padding:25px 20px;margin-bottom:15px;box-shadow:0 4px 10px rgba(0,0,0,0.03);text-align:center; }
        .prof-logo-wrapper { position:relative;width:180px;height:100px;margin:0 auto 15px auto;border-radius:12px;display:flex;justify-content:center;align-items:center;overflow:hidden;background:#e0e0e0; }
        .prof-logo-wrapper::before { content:'';position:absolute;width:300px;height:300px;background:conic-gradient(transparent,transparent,transparent,#00d2ff);animation:rotateBorder 2s linear infinite; }
        .prof-logo-wrapper::after { content:'';position:absolute;inset:3px;background:#f6f7f6;border-radius:9px; }
        .prof-logo-wrapper img { position:relative;z-index:10;width:calc(100% - 6px);height:calc(100% - 6px);object-fit:cover;border-radius:9px; }

        /* Profile avatar circle (top of profile card) */
        .prof-avatar-wrap { position:relative;width:80px;height:80px;margin:0 auto 12px auto; }
        .prof-avatar-circle { width:80px;height:80px;border-radius:50%;background:#b98175;color:white;display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:800;overflow:hidden;border:3px solid #ce9e96; }
        .prof-avatar-circle img { width:100%;height:100%;object-fit:cover;border-radius:50%; }

        .profile-name-text { font-size:20px;font-weight:800;color:#2c2f33;margin-bottom:2px; }
        .profile-email-text { font-size:13px;color:#666;font-weight:700;margin-bottom:15px; }
        .plan-badge-prof { background-color:#558769;color:white;padding:6px 16px;border-radius:20px;display:inline-flex;align-items:center;font-size:13px;font-weight:800;gap:8px; }
        .details-card-box { background-color:#f6f7f6;border-radius:20px;padding:10px 20px;margin-bottom:15px;box-shadow:0 4px 10px rgba(0,0,0,0.03); }
        .list-item { display:flex;align-items:center;padding:15px 0;border-bottom:1.5px solid #eaeaec; }
        .list-item:last-child { border-bottom:none; }
        .icon-box { background-color:#e9eaec;width:38px;height:38px;border-radius:10px;display:flex;justify-content:center;align-items:center;color:#3f424b;font-size:16px; }
        .item-text { margin-left:15px;display:flex;flex-direction:column; }
        .item-label { font-size:11px;color:#8f9298;font-weight:800;text-transform:uppercase;letter-spacing:0.5px; }
        .item-value { font-size:15px;color:#2c2f33;font-weight:800;margin-top:2px; }
        .logout-btn { width:100%;background-color:#b36e6a;color:white;border:none;padding:16px;border-radius:14px;font-size:16px;font-weight:800;cursor:pointer;margin-bottom:15px;display:flex;justify-content:center;align-items:center;gap:10px;box-shadow:0 4px 6px rgba(179,110,106,0.2);font-family:'Grandstander','Nunito',sans-serif; }
        .legal-card-box { background-color:#f6f7f6;border-radius:20px;padding:25px 20px;margin-bottom:15px;box-shadow:0 4px 10px rgba(0,0,0,0.03); }
        .section-title-legal { font-size:13px;color:#444;font-weight:800;text-transform:uppercase;margin-bottom:18px;display:flex;align-items:center;gap:8px; }
        .legal-block { margin-bottom:20px; }
        .legal-block:last-child { margin-bottom:0; }
        .legal-block h4 { font-size:14px;color:#2c2f33;font-weight:800;display:flex;align-items:center;gap:8px;margin-bottom:6px; }
        .legal-block p { font-size:13px;color:#6a6d73;line-height:1.6;font-weight:700; }
        .telegram-link { color:#2c2f33!important;font-weight:800!important;margin-top:5px;display:flex;align-items:center;gap:5px; }

        /* TAB GAMES */
        #tab-games { background-color:#e8e9eb;padding:20px; }
        .game-header { display:flex;align-items:center;gap:12px;margin-bottom:20px; }
        .game-profile-icon { width:45px;height:45px;background-color:#ae756c;color:white;border-radius:50%;display:flex;justify-content:center;align-items:center;font-weight:800;font-size:16px;border:2px solid #ce9e96;overflow:hidden;flex-shrink:0; }
        .game-profile-icon img { width:100%;height:100%;object-fit:cover;border-radius:50%; }
        .game-profile-text { display:flex;flex-direction:column; }
        .game-welcome { font-size:11px;color:#8c8f94;font-weight:700; }
        .game-name { font-size:16px;color:#2c2f33;font-weight:900;text-transform:uppercase; }
        .predictor-banner { background-color:#f7f7f6;border-radius:20px;padding:20px;display:flex;align-items:center;gap:18px;margin-bottom:25px;box-shadow:0 4px 10px rgba(0,0,0,0.03); }
        .banner-logo { width:50px;height:50px;object-fit:contain;flex-shrink:0; }
        .banner-text h2 { font-size:20px;font-weight:900;color:#3d3a52;margin-bottom:3px; }
        .banner-text p { font-size:13px;color:#7b7e85;font-weight:700; }
        .section-label-game { font-size:11px;color:#9a9da3;font-weight:900;letter-spacing:1px;margin-bottom:15px;text-transform:uppercase; }
        .game-types { display:grid;grid-template-columns:1fr 1fr;gap:15px;margin-bottom:25px; }
        .game-card-item { background-color:#f7f7f6;border-radius:18px;padding:25px 15px;text-align:center;cursor:pointer;border:2px solid transparent;transition:all 0.3s;box-shadow:0 4px 10px rgba(0,0,0,0.03); }
        .game-card-item.active { border-color:#4b446a; }
        .game-badge-icon { width:45px;height:45px;margin:0 auto 15px auto;border-radius:50%;display:flex;justify-content:center;align-items:center;color:white;font-size:18px; }
        .badge-green-g { background-color:#5a9367;clip-path:polygon(50% 0%,61% 8%,75% 5%,80% 19%,95% 25%,92% 40%,100% 50%,92% 60%,95% 75%,80% 81%,75% 95%,61% 92%,50% 100%,39% 92%,25% 95%,20% 81%,5% 75%,8% 60%,0% 50%,8% 40%,5% 25%,20% 19%,25% 5%,39% 8%); }
        .badge-dark-g { background-color:#2c2c2c;clip-path:polygon(50% 0%,61% 8%,75% 5%,80% 19%,95% 25%,92% 40%,100% 50%,92% 60%,95% 75%,80% 81%,75% 95%,61% 92%,50% 100%,39% 92%,25% 95%,20% 81%,5% 75%,8% 60%,0% 50%,8% 40%,5% 25%,20% 19%,25% 5%,39% 8%); }
        .game-card-item h3 { font-size:15px;font-weight:900;color:#2c2f33;margin-bottom:4px;text-transform:uppercase; }
        .game-card-item p { font-size:11px;color:#8c8f94;font-weight:700; }
        .hidden-section { display:none; }
        .period-card { background-color:#f7f7f6;border-radius:18px;padding:18px 20px;display:flex;align-items:center;justify-content:space-between;margin-bottom:25px;box-shadow:0 4px 10px rgba(0,0,0,0.03); }
        .period-left { display:flex;align-items:center;gap:15px; }
        .clock-icon { width:38px;height:38px;background-color:#e6e6e9;border-radius:10px;display:flex;justify-content:center;align-items:center; }
        .clock-icon svg { width:20px;height:20px;stroke:#4b446a; }
        .period-label { font-size:15px;font-weight:900;color:#2c2f33;letter-spacing:0.5px; }
        .period-selector { background-color:#4b446a;color:white;padding:10px 18px;border-radius:25px;font-size:13px;font-weight:900;cursor:pointer;display:flex;align-items:center;gap:8px;user-select:none;transition:all 0.2s; }
        .period-selector:active { transform:scale(0.96); }
        .connect-row { display:flex;gap:10px;margin-bottom:20px; }
        .connect-input { flex:1;background-color:#ffffff;border:2px solid #e1e3e6;border-radius:20px;padding:16px 20px;font-size:14px;font-weight:800;color:#2c2f33;outline:none;box-shadow:0 4px 10px rgba(0,0,0,0.02);transition:border-color 0.3s;font-family:'Grandstander','Nunito',sans-serif; }
        .connect-input:focus { border-color:#8b5cf6; }
        .connect-input::placeholder { color:#9a9da3; }
        .connect-btn { background-color:#8b5cf6;color:white;border:none;border-radius:20px;padding:0 25px;font-size:15px;font-weight:900;cursor:pointer;box-shadow:0 4px 10px rgba(139,92,246,0.2);transition:transform 0.2s,background-color 0.2s;font-family:'Grandstander','Nunito',sans-serif;white-space:nowrap; }
        .connect-btn:active { transform:scale(0.95);background-color:#7c4ee5; }
        .connect-btn.connected { background-color:#5a9367; }
        @keyframes slideDown { from{opacity:0;transform:translateY(-15px)} to{opacity:1;transform:translateY(0)} }
        .animate-in { animation:slideDown 0.4s ease forwards; }

        /* WEBVIEW */
        #webview-page { background-color:#ffffff; }
        .wv-header { display:flex;align-items:center;padding:15px 20px;background-color:#ffffff;box-shadow:0 2px 10px rgba(0,0,0,0.04);z-index:10;flex-shrink:0; }
        .wv-back-btn { background:none;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;margin-right:18px;color:#333; }
        .wv-back-btn svg { width:22px;height:22px;fill:currentColor; }
        .wv-logo-container { width:38px;height:38px;border-radius:50%;background-color:#e9ecef;display:flex;align-items:center;justify-content:center;overflow:hidden;margin-right:15px; }
        .wv-logo-container img { width:100%;height:100%;object-fit:cover; }
        .wv-header-title { font-size:16px;font-weight:800;color:#2c2c2c;letter-spacing:0.3px; }
        .wv-main-content { flex:1;background-color:#ffffff;position:relative;overflow:hidden;min-height:0; }
        .wv-main-content iframe { width:100%;height:100%;border:none;display:block; }
        .wv-fab-container { position:absolute;bottom:18px;left:50%;transform:translateX(-50%);z-index:210;transition:all 0.3s; }
        .wv-fab-btn { width:58px;height:58px;background-color:#ffffff;border-radius:50%;border:none;box-shadow:0 4px 15px rgba(0,0,0,0.15);display:flex;justify-content:center;align-items:center;cursor:pointer;color:#4b4d7a;transition:transform 0.2s; }
        .wv-fab-btn:active { transform:scale(0.95); }
        .wv-fab-btn svg { width:24px;height:24px;fill:currentColor; }
        .wv-fab-container.hidden { opacity:0;pointer-events:none;transform:translateX(-50%) scale(0.8); }
        .wv-action-menu { position:absolute;bottom:13px;left:50%;transform:translateX(-50%) scale(0.8);background-color:#f7f8fa;padding:5px;border-radius:40px;box-shadow:0 6px 20px rgba(0,0,0,0.15);display:flex;align-items:center;gap:8px;z-index:215;opacity:0;pointer-events:none;transition:all 0.3s cubic-bezier(0.175,0.885,0.32,1.275); }
        .wv-action-menu.active { opacity:1;pointer-events:auto;transform:translateX(-50%) scale(1); }
        .wv-action-btn { background-color:#4b4e7a;color:#ffffff;border:none;border-radius:25px;padding:12px 22px;font-size:14px;font-weight:800;display:flex;align-items:center;gap:8px;cursor:pointer;letter-spacing:0.5px;font-family:'Grandstander','Nunito',sans-serif; }
        .wv-action-btn:active { background-color:#3a3d63; }
        .wv-action-btn svg { width:16px;height:16px;fill:currentColor; }
        .wv-close-circle-btn { width:38px;height:38px;background-color:#4b4e7a;color:#ffffff;border:none;border-radius:50%;display:flex;justify-content:center;align-items:center;cursor:pointer; }
        .wv-close-circle-btn:active { background-color:#3a3d63; }
        .wv-close-circle-btn svg { width:14px;height:14px;fill:currentColor; }
        .wv-large-sheet { position:absolute;bottom:0;left:0;width:100%;height:88%;background-color:#f4f5f8;border-radius:35px 35px 0 0;z-index:225;transform:translateY(100%);transition:transform 0.4s cubic-bezier(0.2,0.8,0.2,1);display:flex;flex-direction:column;box-shadow:0 -10px 30px rgba(0,0,0,0.1);overflow:hidden; }
        .wv-large-sheet.active { transform:translateY(0); }
        .drag-handle { width:40px;height:4px;background-color:#d1d1d1;border-radius:2px;margin:15px auto 5px auto;flex-shrink:0; }
        .sheet-title { color:#4b4e7a;font-size:18px;font-weight:900;letter-spacing:1px;padding:10px 30px;flex-shrink:0; }
        .sheet-body { flex:1;overflow-y:auto;overflow-x:hidden; }
        .sheet-body::-webkit-scrollbar { display:none; }
        .wv-sheet-backdrop { position:absolute;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.35);z-index:220;opacity:0;pointer-events:none;transition:opacity 0.35s; }
        .wv-sheet-backdrop.active { opacity:1;pointer-events:auto; }

        /* HACK SHEET */
        .hack-container { padding:15px 20px 30px;display:flex;flex-direction:column;align-items:center; }
        .hack-header-logo { width:75%;max-width:220px;margin-bottom:20px;display:block; }
        .period-badge-hack { background-color:#e0e4eb;color:#554e7d;padding:10px 25px;border-radius:30px;font-size:13px;font-weight:800;letter-spacing:1px;margin-bottom:20px;box-shadow:inset 2px 2px 5px rgba(0,0,0,0.05),inset -2px -2px 5px #fff;text-align:center; }
        .hack-main-card { background-color:#eff1f5;width:100%;border-radius:30px;padding:28px 22px;box-shadow:8px 8px 16px rgba(180,184,197,0.4),-8px -8px 16px rgba(255,255,255,0.8); }
        .confidence-header { display:flex;justify-content:space-between;align-items:center;margin-bottom:15px; }
        .confidence-label { color:#554e7d;font-size:12px;font-weight:800;letter-spacing:0.5px; }
        .confidence-value { color:#554e7d;font-size:24px;font-weight:900; }
        .progress-track { width:100%;height:14px;background-color:#d8dbe5;border-radius:10px;margin-bottom:35px;overflow:hidden;box-shadow:inset 1px 1px 3px rgba(0,0,0,0.1); }
        .progress-fill { height:100%;background-color:#554e7d;border-radius:10px;transition:width 0.6s; }
        .stats-row { display:flex;justify-content:space-between;align-items:flex-end;padding:0 10px; }
        .stat-item { display:flex;flex-direction:column;align-items:center; }
        .circle-chart { width:75px;height:75px;border-radius:50%;display:flex;justify-content:center;align-items:center;margin-bottom:15px;box-shadow:2px 2px 5px rgba(0,0,0,0.1);transition:background 0.5s; }
        .circle-inner { width:55px;height:55px;background-color:#eff1f5;border-radius:50%;display:flex;flex-direction:column;justify-content:center;align-items:center;box-shadow:inset 2px 2px 4px rgba(0,0,0,0.05); }
        .inner-text { color:#554e7d;font-size:16px;font-weight:900;line-height:1.1;display:flex;align-items:center;gap:2px;font-family:'Inter',sans-serif; }
        .inner-subtext { color:#554e7d;font-size:8px;font-weight:800; }
        .stat-label { color:#554e7d;font-size:11px;font-weight:800;letter-spacing:0.5px; }
        .target-icon { display:inline-block;width:8px;height:8px;border:2px solid #554e7d;border-radius:50%;position:relative; }
        .target-icon::after { content:'';position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:3px;height:3px;background:#554e7d;border-radius:50%; }

        /* SETTING SHEET */
        /* ===== SETTING SHEET — purple theme like image ===== */
        .setting-container { padding:16px 16px 30px;display:flex;flex-direction:column;gap:14px;background:#f0eeff; }
        /* premium banner */
        .premium-banner-s { background:linear-gradient(135deg,#e8e2ff 0%,#d8ccff 100%);border-radius:20px;padding:22px 20px;display:flex;flex-direction:column;align-items:center;text-align:center;border:1px solid #c9baff; }
        .icon-star-s { width:32px;height:32px;color:#7c5cbf;margin-bottom:10px; }
        .premium-text-s { color:#4a3580;font-size:14px;font-weight:900;letter-spacing:0.5px;line-height:1.4;text-transform:uppercase; }
        /* active server card (top pill card like image) */
        .active-server-card { background:linear-gradient(135deg,#e0d8ff 0%,#cfc4ff 100%);border-radius:18px;padding:16px 18px;border:1.5px solid #b8aaff;display:flex;align-items:center;gap:12px; }
        .asc-check { width:32px;height:32px;background:#34c759;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0; }
        .asc-check svg { width:16px;height:16px;fill:white; }
        .asc-info { flex:1; }
        .asc-name { font-size:15px;font-weight:900;color:#2d1f6e; }
        .asc-sub { font-size:11px;color:#7c6bb0;font-weight:600;margin-top:2px; }
        .asc-remove { background:#ffe5e5;border:1.5px solid #ffb3b3;color:#d93025;font-size:12px;font-weight:800;padding:8px 14px;border-radius:20px;cursor:pointer;border:none;background:#ffe4e4;color:#c0392b; }
        /* prediction type buttons */
        .pred-type-row { display:flex;gap:10px; }
        .pred-btn { flex:1;padding:14px 10px;border-radius:14px;border:1.5px solid #c9baff;background:#ede8ff;font-size:13px;font-weight:900;color:#5a3db0;cursor:pointer;text-align:center;transition:all 0.2s;letter-spacing:0.5px; }
        .pred-btn.active-pred { background:linear-gradient(135deg,#7c5cbf,#9b7fe8);color:#fff;border-color:#7c5cbf;box-shadow:0 4px 12px rgba(124,92,191,0.35); }
        .pred-btn:active { transform:scale(0.97); }
        /* section label */
        .section-title-s { color:#7c6bb0;font-size:11px;font-weight:900;letter-spacing:1.5px;text-transform:uppercase;padding-left:2px;display:flex;align-items:center;gap:8px; }
        .paid-badge-s { background:#e8e2ff;color:#7c5cbf;font-size:10px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #c9baff; }
        /* server grid */
        .servers-grid-s { display:flex;gap:12px; }
        .server-card-s { flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:28px 10px;border-radius:18px;border:2px solid transparent;cursor:pointer;transition:all 0.2s;background:#e8e2ff; }
        .server-card-s .s-icon { width:44px;height:44px;margin-bottom:14px;opacity:0.7;transition:opacity 0.2s; }
        .server-card-s .server-name-s { color:#4a3580;font-size:14px;font-weight:900;letter-spacing:0.5px;opacity:0.7;transition:opacity 0.2s; }
        .server-card-s.active-s { border-color:#7c5cbf;background:#ddd4ff; }
        .server-card-s.active-s .s-icon,.server-card-s.active-s .server-name-s { opacity:1; }
        /* injector row */
        .injector-section-s { display:flex;justify-content:space-between;align-items:center;background:#ede8ff;border-radius:16px;padding:16px 18px;border:1.5px solid #c9baff; }
        .injector-text-s { color:#4a3580;font-size:16px;font-weight:900;letter-spacing:0.5px; }
        .toggle-switch-s { position:relative;display:inline-block;width:56px;height:30px; }
        .toggle-switch-s input { opacity:0;width:0;height:0; }
        .slider-s { position:absolute;cursor:pointer;top:0;left:0;right:0;bottom:0;background-color:#c9baff;transition:.35s;border-radius:30px; }
        .slider-s:before { position:absolute;content:"";height:22px;width:22px;left:4px;bottom:4px;background-color:white;transition:.35s;border-radius:50%;box-shadow:0 2px 6px rgba(0,0,0,0.25); }
        .toggle-switch-s input:checked + .slider-s { background:linear-gradient(90deg,#7c5cbf,#9b7fe8); }
        .toggle-switch-s input:checked + .slider-s:before { transform:translateX(26px); }
        .sheet-footer-txt { display:flex;justify-content:center;align-items:center;gap:6px;color:#9b8cc8;font-size:11px;font-weight:600;padding:10px 0 0; }
        .sheet-footer-txt svg { width:12px;height:12px;fill:currentColor; }
        /* active pred button state tracking */
        #activePredType { display:none; }

        /* INJECTOR */
        #injector-overlay { display:none;position:absolute;top:0;left:0;width:100%;height:100%;z-index:200;pointer-events:none; }
        #injector-overlay.active { display:block;pointer-events:none; }
        #inj-float-logo { position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:60px;height:60px;border-radius:50%;cursor:grab;z-index:201;box-shadow:0 0 0 3px #00a2ff,0 4px 20px rgba(0,162,255,0.5);overflow:hidden;border:2px solid #fff;transition:box-shadow 0.3s;pointer-events:auto; }
        #inj-float-logo:active { cursor:grabbing; }
        #inj-float-logo img { width:100%;height:100%;object-fit:cover;border-radius:50%;pointer-events:none; }
        #inj-float-logo::after { content:'';position:absolute;inset:-6px;border-radius:50%;border:2px solid rgba(0,162,255,0.4);animation:inj-pulse 1.8s ease-out infinite;pointer-events:none; }
        @keyframes inj-pulse { 0%{transform:scale(0.9);opacity:1} 100%{transform:scale(1.35);opacity:0} }
        #inj-modal { display:none;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:238px;background:#050508;border-radius:12px;z-index:202;border:2px solid #1c65ff;box-shadow:0 0 14px rgba(28,101,255,0.55);padding:7px;pointer-events:auto; }
        .inj-header { display:flex;align-items:center;justify-content:flex-start;padding-bottom:6px;cursor:grab; }
        .inj-close-btn { color:white;font-size:15px;cursor:pointer;padding:0 6px; }
        .inj-title { flex-grow:1;text-align:center;font-size:13px;font-weight:900;letter-spacing:0.5px;text-transform:uppercase; }
        .inj-title .nt { background:linear-gradient(to right,#4a67ff,#b435ff);-webkit-background-clip:text;color:transparent; }
        .inj-panel { background:transparent;border:1px solid #444;border-radius:8px;margin-bottom:5px;padding:6px; }
        .inj-top-info { display:flex;justify-content:space-between;align-items:center; }
        .inj-icon-box { width:24px;height:24px;border:1px solid #444;border-radius:4px;display:flex;justify-content:center;align-items:center;color:#d82eff;font-size:13px; }
        .inj-info-text { display:flex;flex-direction:column; }
        .inj-label { color:#777;font-size:8px;margin-bottom:1px; }
        .inj-value { color:#fff;font-size:10px;letter-spacing:0.5px; }
        .inj-time-box { text-align:right; }
        .inj-time-value { color:#35a0ff;font-size:12px;font-weight:bold;letter-spacing:1px; }
        .inj-pred-box { display:flex;justify-content:space-between;align-items:center;padding:6px 4px; }
        .inj-pred-left,.inj-pred-right { text-align:center; }
        .inj-pred-text { font-size:15px;font-weight:900;background:linear-gradient(to right,#d82eff,#ff35a0);-webkit-background-clip:text;color:transparent; }
        .inj-conf-value { font-size:15px;font-weight:900;color:#35a0ff; }
        .inj-center-circle { width:42px;height:42px;border-radius:50%;border:2px solid #1c65ff;padding:2px;position:relative; }
        .inj-center-circle::after { content:'';position:absolute;top:0;left:0;right:0;bottom:0;border-radius:50%;border:1px solid #ff35a0; }
        .inj-center-circle img { width:100%;height:100%;border-radius:50%;object-fit:cover;position:relative;z-index:2; }
        .inj-radio-row { display:flex;justify-content:space-between;align-items:center;border:1px solid #1c65ff;box-shadow:inset 0 0 3px rgba(28,101,255,0.2);padding:5px 6px; }
        .inj-radio-item { display:flex;align-items:center;gap:3px;cursor:pointer; }
        .inj-radio-circle { width:12px;height:12px;border-radius:50%;border:1.5px solid #35a0ff;position:relative; }
        .inj-radio-item input { display:none; }
        .inj-radio-item input:checked + .inj-radio-circle::after { content:'';position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:6px;height:6px;background-color:#35a0ff;border-radius:50%; }
        .inj-radio-label { color:#fff;font-size:8.5px; }
        .inj-get-btn { border:1.5px solid #1c65ff;border-radius:8px;padding:6px;display:flex;align-items:center;justify-content:center;gap:8px;background:#000;cursor:pointer;transition:background 0.2s; }
        .inj-get-btn:active { background:#0a0a20; }
        .inj-get-btn img { width:24px;height:auto; }
        .inj-btn-text { display:flex;flex-direction:column; }
        .inj-btn-title { color:#fff;font-size:13px;font-weight:900;letter-spacing:0.5px; }
        .inj-btn-sub { color:#666;font-size:8px; }
        .inj-loading { display:none;flex-direction:column;align-items:center;gap:6px;padding:8px 0 4px; }
        .inj-spinner { width:28px;height:28px;border:3px solid #1c65ff33;border-top:3px solid #1c65ff;border-radius:50%;animation:inj-spin 0.7s linear infinite; }
        @keyframes inj-spin { to{transform:rotate(360deg)} }
        .inj-loading-text { color:#35a0ff;font-size:9px;font-weight:700;letter-spacing:1px; }
        .inj-result-area { display:none;padding:4px 2px 2px; }
        .inj-result-number { font-size:28px;font-weight:900;background:linear-gradient(to right,#4a67ff,#b435ff);-webkit-background-clip:text;color:transparent;text-align:center;letter-spacing:2px; }
        .inj-result-label { font-size:8px;color:#888;text-align:center;letter-spacing:1px;margin-top:2px; }
        .inj-notice { display:none;background:#ff35a022;border:1px solid #ff35a0;border-radius:6px;padding:5px 8px;color:#ff35a0;font-size:9px;font-weight:700;text-align:center;letter-spacing:0.5px;margin-bottom:4px; }
    </style>
</head>
<body>

<!-- Overlays -->
<div id="server-down-overlay">
    <div class="server-down-box">
        <div class="icon">🔴</div>
        <h2>Server Offline</h2>
        <p>BLZ PREDICTOR server is currently under maintenance. Please try again later.</p>
    </div>
</div>
<div id="loading-overlay">
    <div class="loading-spinner"></div>
    <div id="loading-text">Please wait...</div>
</div>
<div id="toast"></div>

<div class="app-container">

    <!-- ====== SCREEN 0: FIRST SCREEN (exact Frist.html UI) ====== -->
    <div id="screen-first">
        <div class="sf-gradient-bg"></div>

        <div class="sf-image-container">
            <img src="https://i.ibb.co/XfWKqKM0/Picsart-26-06-27-18-40-40-993.png" alt="App UI">
        </div>

        <div class="sf-content">
            <h1 class="sf-title">Maximize Profits with<br>Smart Analytics</h1>

            <button class="sf-btn" id="sfGetStartedBtn">Get Started</button>

            <div class="sf-err-space">
                <span id="sf-err-msg" class="sf-err">Please accept Terms &amp; Conditions first.</span>
            </div>

            <div class="sf-checkbox-area">
                <input type="checkbox" id="termsCheckbox">
                <label for="termsCheckbox">I Accept Terms &amp; Conditions</label>
            </div>

            <p class="sf-subtext">By continuing you agree to our Terms of Services and<br>Privacy Policy</p>

            <div class="sf-footer">
                <a href="#">Privacy &amp; Policy</a>
                <a href="#">Terms &amp; Conditions</a>
                <a href="#">Disclaimer</a>
            </div>
        </div>
    </div>

    <!-- ====== LANDING PAGE (key check) ====== -->
    <div id="landing-page">
        <div class="landing-image-container anim-fade-up delay-1">
            <img src="https://i.ibb.co/1t8dGDLQ/Picsart-26-06-27-18-17-19-908.png" alt="Preview" class="landing-image">
        </div>
        <div class="landing-content-area">
            <h1 class="landing-title anim-fade-up delay-2">YOUR GROWTH<br>JOURNEY:<br>SIMPLE &amp; SECURE</h1>
            <p class="landing-subtitle anim-fade-up delay-2">Smart predictions powered by BLZ AI<br>- Real time accuracy</p>
            <div class="landing-cards-row anim-fade-up delay-3">
                <div class="l-card join" onclick="window.open('https://t.me/+369U0Rvkz7UyMTRl','_blank')">
                    <div class="l-card-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M22 2L11 13" stroke="black" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M22 2L15 22L11 13L2 9L22 2Z" fill="black"></path></svg>
                    </div>
                    <div class="l-card-text"><strong>Join<br>Channel</strong><span>• Get latest<br>updates!</span></div>
                </div>
                <div class="l-card support" onclick="window.open('http://t.me/AssistBlzBhai_bot','_blank')">
                    <div class="l-card-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M3 18V12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12V18" stroke="black" stroke-width="2.5" stroke-linecap="round"></path><path d="M3 14H6C7.10457 14 8 14.8954 8 16V19C8 20.1046 7.10457 21 6 21H3V14Z" fill="black"></path><path d="M21 14H18C16.8954 14 16 14.8954 16 16V19C16 20.1046 16.8954 21 18 21H21V14Z" fill="black"></path></svg>
                    </div>
                    <div class="l-card-text"><strong>Customer<br>&amp; Support</strong><span>• We are here to<br>help!</span></div>
                </div>
            </div>
            <button id="get-sub-btn" class="landing-main-btn anim-fade-up delay-4" onclick="window.open('https://t.me/+369U0Rvkz7UyMTRl','_blank')">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="#FFFFFF"><path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5zm14 3c0 .6-.4 1-1 1H6c-.6 0-1-.4-1-1v-1h14v1z"></path></svg>
                Get Subscription
            </button>
            <div class="device-id-display anim-fade-up delay-5">
                Device I'D: <span id="display-device-id">Loading...</span>
                <div class="copy-icon-btn" id="copy-id-btn">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M8 8H18V18H8V8Z" stroke="black" stroke-width="2.5" stroke-linejoin="round"></path><path d="M16 8V6H6V16H8" stroke="black" stroke-width="2.5" stroke-linejoin="round"></path></svg>
                </div>
            </div>
            <div class="landing-footer anim-fade-up delay-5">
                <div><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg> Privacy &amp; Policy</div>
                <div><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg> Terms &amp; Conditions</div>
            </div>
        </div>
    </div>

    <!-- ====== BLZ PREDICTOR MAIN PAGE ====== -->
    <div class="page" id="main-page">
        <div class="content-area">

            <!-- TAB HOME -->
            <div class="tab-panel active" id="tab-home">
                <div style="padding:20px 15px;">
                    <div class="home-header">
                        <div class="avatar" id="homeAvatar">BL</div>
                        <div class="user-info">
                            <span class="welcome-text">Welcome back,</span>
                            <span class="user-name" id="homeUserName">BLZ USER</span>
                        </div>
                    </div>
                    <div class="main-card">
                        <div class="logo-wrapper"><img src="https://i.ibb.co/j79FVyw/Gemini-Generated-Image-hfi69vhfi69vhfi6.png" alt="Logo"></div>
                        <h1>BLZ PREDICTOR</h1>
                        <p>Advanced AI-powered prediction tool with real-time injector support for accurate game insights.</p>
                        <div class="badge"><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> PREMIUM ACTIVE</div>
                    </div>
                    <div class="grid-container">
                        <div class="grid-card" onclick="switchTab('games')"><svg viewBox="0 0 24 24"><path d="M20.5 8C20.5 8 21.5 16 20.5 18C19.5 20 18 19.5 17 18C16 16.5 15 15 15 15H9C9 15 8 16.5 7 18C6 19.5 4.5 20 3.5 18C2.5 16 3.5 8 3.5 8C3.5 6 6.5 5 8.5 5H15.5C17.5 5 20.5 6 20.5 8Z"/></svg><h3>Predictor</h3><p>Launch the game predictor</p></div>
                        <div class="grid-card" onclick="switchTab('plan')"><svg viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM10.46 15.83l-3-3 1.41-1.41 1.59 1.59 4.58-4.59 1.41 1.41z"/></svg><h3>My Plan</h3><p>View &amp; manage plan</p></div>
                        <div class="grid-card" onclick="window.open('https://t.me/+369U0Rvkz7UyMTRl','_blank')"><svg viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H5.17L4 17.17V4h16v12zm-9-4h2v2h-2zm0-6h2v4h-2z"/></svg><h3>Channel</h3><p>Latest updates</p></div>
                        <div class="grid-card" onclick="window.open('http://t.me/AssistBlzBhai_bot','_blank')"><svg viewBox="0 0 24 24"><path d="M12 3c-4.97 0-9 4.03-9 9v7c0 1.1.9 2 2 2h4v-8H5v-1c0-3.87 3.13-7 7-7s7 3.13 7 7v1h-4v8h4c1.1 0 2-.9 2-2v-7c0-4.97-4.03-9-9-9z"/></svg><h3>Support</h3><p>We are here to help</p></div>
                    </div>
                </div>
            </div>

            <!-- TAB PLAN -->
            <div class="tab-panel" id="tab-plan" style="background:#efefef;display:none;flex-direction:column;min-height:100%;">
                <div class="plan-header">
                    <div class="plan-profile-icon" id="planAvatar">BL</div>
                    <div class="plan-profile-text"><span class="plan-welcome">Welcome,</span><span class="plan-name" id="planUserName">BLZ USER</span></div>
                </div>
                <div class="plan-main">
                    <div class="animated-logo-wrapper"><img src="https://i.ibb.co/j79FVyw/Gemini-Generated-Image-hfi69vhfi69vhfi6.png" alt="Logo"></div>
                    <h2 class="plan-title" id="plan-page-title">Select Your Plan</h2>
                    <p class="plan-subtitle">Subscribe today and unlock powerful tools, real-time insights, and premium support.</p>
                    <div class="plan-loading" id="plan-loading-text">Loading plans...</div>
                    <div class="plans-wrapper" id="plans-wrapper">
                        <div class="upgrade-label">UPGRADE YOUR PLAN</div>
                        <div class="carousel" id="plan-carousel">
                            <div class="plan-card"><div class="plan-price-title">FREE</div><div class="features-grid"><div class="feature-item"><i class="fa-regular fa-circle-dot feature-icon"></i> Limited Resources</div><div class="feature-item"><i class="fa-regular fa-circle-dot feature-icon"></i> Inbuild Platform</div><div class="feature-item"><i class="fa-regular fa-circle-dot feature-icon"></i> 1 Script</div></div></div>
                            <div class="plan-card"><div class="plan-price-title">299 ₹ 3 Days</div><div class="features-grid"><div class="feature-item"><i class="fa-regular fa-circle-dot feature-icon"></i> Advance AI</div><div class="feature-item"><i class="fa-regular fa-circle-dot feature-icon"></i> Daily Script</div><div class="feature-item"><i class="fa-regular fa-circle-dot feature-icon"></i> Best Server</div><div class="feature-item"><i class="fa-regular fa-circle-dot feature-icon"></i> 24x7 Support</div><div class="feature-item"><i class="fa-regular fa-circle-dot feature-icon"></i> Ad Free</div><div class="feature-item"><i class="fa-regular fa-circle-dot feature-icon"></i> All Game</div></div></div>
                            <div class="plan-card"><div class="plan-price-title">549 ₹ 7 Days <span class="discount-badge">15% off!</span></div><div class="features-grid"><div class="feature-item"><i class="fa-regular fa-circle-dot feature-icon"></i> Advance AI</div><div class="feature-item"><i class="fa-regular fa-circle-dot feature-icon"></i> Daily Script</div><div class="feature-item"><i class="fa-regular fa-circle-dot feature-icon"></i> Best Server</div><div class="feature-item"><i class="fa-regular fa-circle-dot feature-icon"></i> 24x7 Support</div><div class="feature-item"><i class="fa-regular fa-circle-dot feature-icon"></i> Ad Free</div><div class="feature-item"><i class="fa-regular fa-circle-dot feature-icon"></i> All Game</div></div></div>
                            <div class="plan-card"><div class="plan-price-title">999 ₹ 15 Days <span class="discount-badge">20% off!</span></div><div class="features-grid"><div class="feature-item"><i class="fa-regular fa-circle-dot feature-icon"></i> Advance AI</div><div class="feature-item"><i class="fa-regular fa-circle-dot feature-icon"></i> Daily Script</div><div class="feature-item"><i class="fa-regular fa-circle-dot feature-icon"></i> Best Server</div><div class="feature-item"><i class="fa-regular fa-circle-dot feature-icon"></i> 24x7 Support</div><div class="feature-item"><i class="fa-regular fa-circle-dot feature-icon"></i> Ad Free</div><div class="feature-item"><i class="fa-regular fa-circle-dot feature-icon"></i> All Game</div></div></div>
                        </div>
                    </div>
                </div>
                <div class="bottom-actions">
                    <div class="button-row">
                        <button class="btn-primary btn-disabled" id="plan-main-btn">Select a plan to continue</button>
                        <button class="btn-status" id="plan-status-btn">Check Status</button>
                    </div>
                </div>
            </div>

            <!-- TAB PROFILE -->
            <div class="tab-panel" id="tab-profile" style="background:#dadddf;padding:20px;">
                <div class="profile-card-box">
                    <div class="prof-logo-wrapper"><img src="https://i.ibb.co/j79FVyw/Gemini-Generated-Image-hfi69vhfi69vhfi6.png" alt="Logo"></div>
                    <!-- User avatar with photo or initials -->
                    <div class="prof-avatar-wrap">
                        <div class="prof-avatar-circle" id="profAvatarCircle">BL</div>
                    </div>
                    <!-- Gmail shown ABOVE name -->
                    <div class="profile-email-text" id="profileDisplayEmail" style="margin-bottom:4px;margin-top:2px;">user@gmail.com</div>
                    <div class="profile-name-text" id="profileDisplayName">BLZ USER</div>
                    <div class="plan-badge-prof" style="margin-top:12px;"><i class="fa-regular fa-circle-check"></i> <span id="profPlanBadge">Loading...</span></div>
                </div>
                <div class="details-card-box">
                    <div class="list-item"><div class="icon-box"><i class="fa-solid fa-envelope"></i></div><div class="item-text"><span class="item-label">GMAIL</span><span class="item-value" id="profEmail">—</span></div></div>
                    <div class="list-item"><div class="icon-box"><i class="fa-solid fa-user"></i></div><div class="item-text"><span class="item-label">NAME</span><span class="item-value" id="profName">—</span></div></div>
                    <div class="list-item"><div class="icon-box"><i class="fa-brands fa-telegram"></i></div><div class="item-text"><span class="item-label">TELEGRAM USERNAME</span><span class="item-value" id="profTelegram">@Blazeden</span></div></div>
                    <div class="list-item"><div class="icon-box"><i class="fa-solid fa-id-badge"></i></div><div class="item-text"><span class="item-label">TELEGRAM ID</span><span class="item-value" id="profTelegramId">@Blazeden</span></div></div>
                    <div class="list-item"><div class="icon-box"><i class="fa-solid fa-calendar-check"></i></div><div class="item-text"><span class="item-label">CURRENT PLAN</span><span class="item-value" id="profCurrentPlan">Loading...</span></div></div>
                    <div class="list-item"><div class="icon-box"><i class="fa-solid fa-hourglass-half"></i></div><div class="item-text"><span class="item-label">PLAN DURATION</span><span class="item-value" id="profPlanDuration">—</span></div></div>
                    <div class="list-item"><div class="icon-box"><i class="fa-solid fa-clock"></i></div><div class="item-text"><span class="item-label">DAYS LEFT</span><span class="item-value" id="profDaysLeft">—</span></div></div>
                    <div class="list-item"><div class="icon-box"><i class="fa-solid fa-calendar-days"></i></div><div class="item-text"><span class="item-label">EXPIRES ON</span><span class="item-value" id="profExpiresOn">—</span></div></div>
                </div>
                <button class="logout-btn" onclick="handleLogout()"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</button>
                <div class="legal-card-box">
                    <div class="section-title-legal"><i class="fa-solid fa-scale-balanced"></i> LEGAL</div>
                    <div class="legal-block"><h4><i class="fa-solid fa-shield-halved"></i> Privacy Policy</h4><p>BLZ Predictor aapka naam, email aur Telegram ID sirf account verification ke liye collect karta hai. Data Firebase par securely store hota hai.</p></div>
                    <div class="legal-block"><h4><i class="fa-solid fa-circle-exclamation"></i> Disclaimer</h4><p>BLZ Predictor ek prediction tool hai aur yeh kisi financial gain ya loss ki guarantee nahi deta. Real money gaming mein involve hona aapki apni zimmedari hai.</p></div>
                    <div class="legal-block"><h4><i class="fa-solid fa-envelope"></i> Contact</h4><p>Kisi bhi query ke liye support se contact kare:</p><p class="telegram-link"><i class="fa-brands fa-telegram"></i> @AssistBlzBhai_bot on Telegram</p></div>
                </div>
            </div>

            <!-- TAB GAMES -->
            <div class="tab-panel" id="tab-games" style="background:#e8e9eb;padding:20px;">
                <div class="game-header">
                    <div class="game-profile-icon" id="gamesAvatar">BL</div>
                    <div class="game-profile-text"><span class="game-welcome">Welcome back,</span><span class="game-name" id="gamesUserName">BLZ USER</span></div>
                </div>
                <div class="predictor-banner">
                    <img class="banner-logo" src="https://i.ibb.co/mnHDqWH/Picsart-26-06-21-21-31-59-962.png" alt="Logo">
                    <div class="banner-text"><h2>Game Predictor</h2><p>Apna game aur period select karo.</p></div>
                </div>
                <div class="section-label-game">SELECT GAME TYPE</div>
                <div class="game-types">
                    <div class="game-card-item" id="trx-card" onclick="selectGame('trx')"><div class="game-badge-icon badge-green-g"><i class="fa-solid fa-check"></i></div><h3>TRX WINGO</h3><p>TRX Prediction</p></div>
                    <div class="game-card-item" id="wingo-card" onclick="selectGame('wingo')"><div class="game-badge-icon badge-dark-g"><i class="fa-solid fa-check"></i></div><h3>WINGO</h3><p>Color Prediction</p></div>
                </div>
                <div class="hidden-section" id="hidden-section">
                    <div class="period-card">
                        <div class="period-left">
                            <div class="clock-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></div>
                            <span class="period-label">PERIOD</span>
                        </div>
                        <div class="period-selector" id="period-selector" onclick="togglePeriod()"><span id="period-value">30 SEC</span><i class="fa-solid fa-chevron-down"></i></div>
                    </div>
                    <div class="section-label-game">SELECT PLATFORM</div>
                    <div class="connect-row">
                        <input type="text" class="connect-input" id="game-url-input" placeholder="Enter Game URL">
                        <button class="connect-btn" id="connect-btn" onclick="connectGameURL()">Connect</button>
                    </div>
                </div>
            </div>

        </div><!-- end content-area -->

        <!-- BOTTOM NAV -->
        <div class="bottom-nav">
            <div class="nav-item active" data-tab="home" onclick="switchTab('home')"><div class="nav-icon-wrapper"><svg width="26" height="26" viewBox="0 0 24 24" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C10.8 2 9.8 2.7 9.1 3.7L3.6 10.9C2.6 12.2 2 13.9 2 15.6V19.5C2 21.4 3.6 23 5.5 23H18.5C20.4 23 22 21.4 22 19.5V15.6C22 13.9 21.4 12.2 20.4 10.9L14.9 3.7C14.2 2.7 13.2 2 12 2Z" fill="#957DEC"/><rect x="9.5" y="15.5" width="5" height="1.5" rx="0.75" fill="white"/></svg></div><span class="nav-text">Home</span></div>
            <div class="nav-item" data-tab="games" onclick="switchTab('games')"><div class="nav-icon-wrapper"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M20.5 8C20.5 8 21.5 16 20.5 18C19.5 20 18 19.5 17 18C16 16.5 15 15 15 15H9C9 15 8 16.5 7 18C6 19.5 4.5 20 3.5 18C2.5 16 3.5 8 3.5 8C3.5 6 6.5 5 8.5 5H15.5C17.5 5 20.5 6 20.5 8Z" fill="#1c1c1e"/><path d="M7 9V11M5.5 10H8.5" stroke="white" stroke-width="1.5" stroke-linecap="round"/><circle cx="16.5" cy="8.5" r="1.2" fill="white"/><circle cx="18.5" cy="10.5" r="1.2" fill="white"/><circle cx="16.5" cy="12.5" r="1.2" fill="white"/><circle cx="14.5" cy="10.5" r="1.2" fill="white"/></svg></div><span class="nav-text">Games</span></div>
            <div class="nav-item" data-tab="plan" onclick="switchTab('plan')"><div class="nav-icon-wrapper"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="4" fill="#957DEC"/><path d="M7 12H17M7 8H13M7 16H11" stroke="white" stroke-width="2" stroke-linecap="round"/></svg></div><span class="nav-text">My Plan</span></div>
            <div class="nav-item" data-tab="profile" onclick="switchTab('profile')"><div class="nav-icon-wrapper"><svg width="26" height="26" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="12" fill="#1c1c1e"/><path d="M5.5 18C7 16.5 7.5 15.5 7.5 13.5V12.5C6 11.5 5.5 10 5.5 8C5.5 5.5 8 3.5 12 3.5C16 3.5 18.5 5.5 18.5 8C18.5 10 18 11.5 16.5 12.5V13.5C16.5 15.5 17 16.5 18.5 18" stroke="white" stroke-width="1.5" stroke-linecap="round"/><path d="M7.5 18H16.5" stroke="white" stroke-width="1.5"/></svg></div><span class="nav-text">Profile</span></div>
        </div>
    </div><!-- end main-page -->

    <!-- WEBVIEW PAGE -->
    <div class="page" id="webview-page">
        <header class="wv-header">
            <button class="wv-back-btn" onclick="closeWebviewPage()"><svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg></button>
            <div class="wv-logo-container"><img src="https://i.ibb.co/j79FVyw/Gemini-Generated-Image-hfi69vhfi69vhfi6.png" alt="Logo"></div>
            <div class="wv-header-title">BLZ PREDICTOR</div>
        </header>
        <div class="wv-main-content">
            <iframe id="game-iframe" src="" sandbox="allow-scripts allow-same-origin allow-forms allow-popups allow-top-navigation" allow="accelerometer;camera;encrypted-media;geolocation;gyroscope;microphone;payment"></iframe>
        </div>
        <div class="wv-sheet-backdrop" id="wvSheetBackdrop"></div>
        <div class="wv-large-sheet" id="wvLargeSheet">
            <div class="drag-handle"></div>
            <div class="sheet-title" id="wvSheetTitle">HACK</div>
            <div class="sheet-body" id="wvSheetBody"></div>
        </div>
        <div class="wv-fab-container" id="wvFabContainer">
            <button class="wv-fab-btn" id="wvOpenMenuBtn"><svg viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg></button>
        </div>
        <div class="wv-action-menu" id="wvActionMenu">
            <button class="wv-action-btn" id="wvHackBtn"><svg viewBox="0 0 24 24"><path d="M7 2v11h3v9l7-12h-4l4-8z"/></svg> HACK</button>
            <button class="wv-close-circle-btn" id="wvCloseMenuBtn"><svg viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg></button>
            <button class="wv-action-btn" id="wvSettingBtn"><svg viewBox="0 0 24 24"><path d="M19.14,12.94c0.04-0.3,0.06-0.61,0.06-0.94c0-0.32-0.02-0.64-0.06-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41h-3.84c-0.24,0-0.43,0.17-0.47,0.41L9.25,5.35C8.66,5.59,8.12,5.92,7.63,6.29L5.24,5.33c-0.22-0.08-0.47,0-0.59,0.22L2.73,8.87C2.62,9.08,2.66,9.34,2.86,9.48l2.03,1.58C4.84,11.36,4.8,11.69,4.8,12s0.02,0.64,0.06,0.94l-2.03,1.58c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.43-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96c0.22,0.08,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.49-0.12-0.61L19.14,12.94z M12,15.6c-1.98,0-3.6-1.62-3.6-3.6s1.62-3.6,3.6-3.6s3.6,1.62,3.6,3.6S13.98,15.6,12,15.6z"/></svg> SETTING</button>
        </div>
        <!-- INJECTOR OVERLAY -->
        <div id="injector-overlay">
            <div id="inj-float-logo"><img src="https://i.ibb.co/j79FVyw/Gemini-Generated-Image-hfi69vhfi69vhfi6.png" alt="Injector"></div>
            <div id="inj-modal">
                <div class="inj-header" id="inj-modal-header">
                    <span class="inj-close-btn" id="injCloseBtn">✕</span>
                    <div class="inj-title"><span class="nt">BLZ PREDICTOR</span></div>
                </div>
                <div class="inj-panel inj-top-info">
                    <div style="display:flex;gap:6px;align-items:center;">
                        <div class="inj-icon-box"><span>⚙</span></div>
                        <div class="inj-info-text"><span class="inj-label">Period Number</span><span class="inj-value" id="injPeriodNum">—</span></div>
                    </div>
                    <div class="inj-time-box"><div class="inj-label">Time Remaining</div><div class="inj-time-value" id="injTimeRem">—</div></div>
                </div>
                <div class="inj-panel inj-pred-box" id="injPredBox">
                    <div class="inj-pred-left"><div class="inj-label">PREDICTION</div><div class="inj-pred-text" id="injPredText">—</div></div>
                    <div class="inj-center-circle"><img src="https://i.ibb.co/j79FVyw/Gemini-Generated-Image-hfi69vhfi69vhfi6.png" alt="logo"></div>
                    <div class="inj-pred-right"><div class="inj-label">CONFIDENCE</div><div class="inj-conf-value" id="injConfText">—</div></div>
                </div>
                <div class="inj-notice" id="injNotice">⚠ Please select an option first!</div>
                <div class="inj-loading" id="injLoading"><div class="inj-spinner"></div><div class="inj-loading-text">ANALYZING...</div></div>
                <div class="inj-result-area" id="injResultArea"><div class="inj-result-number" id="injResultNumber">—</div><div class="inj-result-label">PREDICTED NUMBER</div></div>
                <div class="inj-panel inj-radio-row" style="margin-bottom:4px;" id="injRow1Panel">
                    <label class="inj-radio-item"><input type="radio" name="injRow1" value="bigsmall" onchange="injRow1Change(this)"><div class="inj-radio-circle"></div><span class="inj-radio-label">Big/Small</span></label>
                    <label class="inj-radio-item"><input type="radio" name="injRow1" value="redgreen" onchange="injRow1Change(this)"><div class="inj-radio-circle"></div><span class="inj-radio-label">Red/Green</span></label>
                    <label class="inj-radio-item"><input type="radio" name="injRow1" value="number" onchange="injRow1Change(this)"><div class="inj-radio-circle"></div><span class="inj-radio-label">Number</span></label>
                </div>
                <div class="inj-panel inj-radio-row" id="injRow2Panel">
                    <label class="inj-radio-item"><input type="radio" name="injRow2" value="v1" onchange="injRow2Change(this)"><div class="inj-radio-circle"></div><span class="inj-radio-label">V1</span></label>
                    <label class="inj-radio-item"><input type="radio" name="injRow2" value="v2" onchange="injRow2Change(this)"><div class="inj-radio-circle"></div><span class="inj-radio-label">V2</span></label>
                    <label class="inj-radio-item"><input type="radio" name="injRow2" value="ai" onchange="injRow2Change(this)"><div class="inj-radio-circle"></div><span class="inj-radio-label">AI</span></label>
                    <label class="inj-radio-item"><input type="radio" name="injRow2" value="calc" onchange="injRow2Change(this)"><div class="inj-radio-circle"></div><span class="inj-radio-label">Calculation</span></label>
                </div>
                <div class="inj-get-btn" id="injGetBtn">
                    <img src="https://i.ibb.co/mnHDqWH/Picsart-26-06-21-21-31-59-962.png" alt="Logo">
                    <div class="inj-btn-text"><span class="inj-btn-title">GET RESULT</span><span class="inj-btn-sub">click to get live predictions</span></div>
                </div>
            </div>
        </div>
    </div><!-- end webview-page -->

</div><!-- end app-container -->

<!-- Firebase SDKs (compat for auth) -->
<script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-auth-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-database-compat.js"></script>

<script>
/* ============================================================
   FIREBASE INIT
============================================================ */
const firebaseConfig = {
    apiKey:            "AIzaSyAvQZJyLchbmwhs_u_SpHmkQU98Q7K8niA",
    authDomain:        "thesharkbyblz-db208.firebaseapp.com",
    databaseURL:       "https://thesharkbyblz-db208-default-rtdb.firebaseio.com",
    projectId:         "thesharkbyblz-db208",
    storageBucket:     "thesharkbyblz-db208.firebasestorage.app",
    messagingSenderId: "821159863328",
    appId:             "1:821159863328:android:bb0be3f869cab24ea30845"
};
firebase.initializeApp(firebaseConfig);
const auth = firebase.auth();
const db   = firebase.database();
const googleProvider = new firebase.auth.GoogleAuthProvider();
googleProvider.addScope('email');
googleProvider.addScope('profile');

/* ============================================================
   STATE
============================================================ */
let currentUser = null;
let planLoaded = false;
let selectedGame = 'wingo';
let selectedPeriod = '30s';
let hackTimerInterval = null;
let hackLevel = 'L1';
let lastCheckedPeriod = null;
let resultPngShowing = false;
let injectorActive = false;
let injTimerInterval = null;
let hackWinRate = 100;
let hackTotalBets = 0;
let injRow1Selected = null;
let injRow2Selected = null;
let injResultShowing = false;
let shownPredictions = {};
let injCurrentClickedPeriod = null;

const PNG_BIG     = 'https://i.ibb.co/cSpHJC85/Picsart-26-06-26-14-48-01-068.png';
const PNG_SMALL   = 'https://i.ibb.co/20nB3TCy/Picsart-26-06-26-14-48-12-014.png';
const PNG_LOADING = 'https://i.ibb.co/mCqSSYV2/Picsart-26-06-27-07-16-31-293.png';

/* ============================================================
   UTILITIES
============================================================ */
function showToast(msg) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 3000);
}
function showLoading(text='Please wait...') {
    document.getElementById('loading-text').textContent = text;
    document.getElementById('loading-overlay').classList.add('show');
}
function hideLoading() {
    document.getElementById('loading-overlay').classList.remove('show');
}

/* ============================================================
   UPDATE UI WITH USER DATA
============================================================ */
function updateUIWithUser(user) {
    if (!user) return;
    currentUser = user;

    const name  = user.displayName || 'BLZ User';
    const email = user.email || '';
    const photo = user.photoURL || '';

    // Initials
    const initials = name.split(' ').map(w => w[0]).slice(0,2).join('').toUpperCase() || 'BL';

    // Home tab
    const homeAvatar = document.getElementById('homeAvatar');
    if (photo) {
        homeAvatar.innerHTML = `<img src="${photo}" alt="avatar" onerror="this.parentElement.textContent='${initials}'">`;
    } else {
        homeAvatar.textContent = initials;
    }
    document.getElementById('homeUserName').textContent = name;

    // Plan tab
    const planAvatar = document.getElementById('planAvatar');
    if (photo) {
        planAvatar.innerHTML = `<img src="${photo}" alt="avatar" onerror="this.parentElement.textContent='${initials}'">`;
    } else {
        planAvatar.textContent = initials;
    }
    document.getElementById('planUserName').textContent = name;

    // Games tab
    const gamesAvatar = document.getElementById('gamesAvatar');
    if (photo) {
        gamesAvatar.innerHTML = `<img src="${photo}" alt="avatar" onerror="this.parentElement.textContent='${initials}'">`;
    } else {
        gamesAvatar.textContent = initials;
    }
    document.getElementById('gamesUserName').textContent = name;

    // Profile tab
    const profAvatarCircle = document.getElementById('profAvatarCircle');
    if (photo) {
        profAvatarCircle.innerHTML = `<img src="${photo}" alt="avatar" onerror="this.parentElement.textContent='${initials}'">`;
    } else {
        profAvatarCircle.textContent = initials;
    }
    document.getElementById('profileDisplayEmail').textContent = email;
    document.getElementById('profileDisplayName').textContent = name;
    document.getElementById('profEmail').textContent = email;
    document.getElementById('profName').textContent = name;
}

/* ============================================================
   FETCH & DISPLAY PLAN DATA FROM FIREBASE
============================================================ */
function loadPlanData(uid) {
    // Try to find user by uid in users node, then check approved_devices via email key
    db.ref('users/' + uid).once('value').then(snap => {
        const userData = snap.val() || {};
        // Update telegram fields if available
        if (userData.telegramUsername) document.getElementById('profTelegram').textContent = userData.telegramUsername;
        if (userData.telegramId) document.getElementById('profTelegramId').textContent = userData.telegramId;
    }).catch(e => console.warn('user node read error:', e));

    // Also try to find plan info under approved_devices by uid or by email
    const email = currentUser ? (currentUser.email || '') : '';
    const emailKey = email.replace(/\./g, '_').replace(/@/g, '_at_');

    // Try approved_devices node with uid
    db.ref('approved_devices/' + uid).once('value').then(snap => {
        const d = snap.val();
        if (d) { applyPlanToProfile(d); return; }
        // Try with emailKey
        return db.ref('approved_devices/' + emailKey).once('value');
    }).then(snap2 => {
        if (snap2 && snap2.val()) applyPlanToProfile(snap2.val());
        else {
            // No plan found – show defaults
            document.getElementById('profCurrentPlan').textContent = 'No Active Plan';
            document.getElementById('profPlanDuration').textContent = '—';
            document.getElementById('profDaysLeft').textContent = '—';
            document.getElementById('profExpiresOn').textContent = '—';
            document.getElementById('profPlanBadge').textContent = 'No Plan';
        }
    }).catch(e => {
        console.warn('plan fetch error:', e);
        document.getElementById('profCurrentPlan').textContent = 'Error loading';
    });
}

function applyPlanToProfile(data) {
    const plan = data.plan || data.currentPlan || '';
    const duration = data.duration || data.planDuration || '';
    const expiry = data.expiry || data.expiresOn || null;

    // Days + hours left
    let daysLeft = '—';
    let expiresOn = '—';
    if (expiry) {
        const expiryDate = new Date(expiry);
        const now = new Date();
        const diffMs = expiryDate - now;
        if (diffMs > 0) {
            const totalHours = Math.floor(diffMs / (1000 * 60 * 60));
            const days = Math.floor(totalHours / 24);
            const hours = totalHours % 24;
            if (days > 0) {
                daysLeft = days + ' day' + (days !== 1 ? 's' : '') + (hours > 0 ? ' ' + hours + ' hr' : '');
            } else {
                daysLeft = hours + ' hour' + (hours !== 1 ? 's' : '');
            }
        } else {
            daysLeft = 'Expired';
        }
        expiresOn = expiryDate.toLocaleDateString('en-IN', {day:'2-digit', month:'short', year:'numeric'});
    }

    const planText = plan || 'Active Plan';
    const durationText = duration || '—';

    document.getElementById('profCurrentPlan').textContent = planText;
    document.getElementById('profPlanDuration').textContent = durationText;
    document.getElementById('profDaysLeft').textContent = daysLeft;
    document.getElementById('profExpiresOn').textContent = expiresOn;
    document.getElementById('profPlanBadge').textContent = planText;
}

/* ============================================================
   SCREEN 0: FIRST SCREEN — GET STARTED button
============================================================ */
document.getElementById('sfGetStartedBtn').addEventListener('click', async () => {
    const checkbox = document.getElementById('termsCheckbox');
    const errMsg   = document.getElementById('sf-err-msg');
    if (!checkbox.checked) {
        errMsg.style.display = 'block';
        const btn = document.getElementById('sfGetStartedBtn');
        btn.style.transform = 'translateX(-8px)';
        setTimeout(() => btn.style.transform = 'translateX(8px)', 100);
        setTimeout(() => btn.style.transform = 'translateX(-4px)', 200);
        setTimeout(() => btn.style.transform = 'translateX(4px)', 300);
        setTimeout(() => btn.style.transform = 'translateX(0)', 400);
        return;
    }
    errMsg.style.display = 'none';
    // Check if already logged in via Firebase Auth
    const user = auth.currentUser;
    if (user) {
        updateUIWithUser(user);
        loadPlanData(user.uid);
        // Skip to landing/main directly — go through access flow
        document.getElementById('screen-first').classList.add('hide');
        setTimeout(() => { document.getElementById('screen-first').style.display='none'; }, 500);
        showLandingAndCheckAccess();
        return;
    }

    // Not logged in — show Google sign-in popup
    showLoading('Opening Google Sign In...');
    const btn = document.getElementById('sfGetStartedBtn');
    btn.disabled = true;

    try {
        const result = await auth.signInWithPopup(googleProvider);
        const fbUser = result.user;

        // Save user to Firebase
        db.ref('users/' + fbUser.uid).update({
            name:          fbUser.displayName || '',
            email:         fbUser.email || '',
            photoURL:      fbUser.photoURL || '',
            uid:           fbUser.uid,
            emailVerified: fbUser.emailVerified,
            lastLogin:     new Date().toISOString()
        }).catch(e => console.warn('DB write err:', e));

        hideLoading();
        updateUIWithUser(fbUser);
        loadPlanData(fbUser.uid);

        // Hide first screen, go to landing key check
        // auth-ready will be added once access is confirmed (5s on landing)
        document.getElementById('screen-first').classList.add('hide');
        setTimeout(() => { document.getElementById('screen-first').style.display='none'; }, 500);
        showLandingAndCheckAccess();

    } catch (err) {
        hideLoading();
        btn.disabled = false;
        let msg = 'Sign in failed. Try again.';
        if (err.code === 'auth/popup-closed-by-user')   msg = 'Popup closed. Please try again.';
        if (err.code === 'auth/popup-blocked')          msg = 'Popup blocked! Allow popups.';
        if (err.code === 'auth/network-request-failed') msg = 'No internet connection.';
        if (err.code === 'auth/unauthorized-domain')    msg = 'Domain not authorized in Firebase.';
        showToast('❌ ' + msg);
        console.error('Sign in error:', err);
    }
});

document.getElementById('termsCheckbox').addEventListener('change', function() {
    if (this.checked) document.getElementById('sf-err-msg').style.display = 'none';
});

function showAccessOverlay(name) {
    document.getElementById('access-sub-text').textContent = 'Welcome, ' + (name || 'User') + '! Opening BLZ Predictor...';
    document.getElementById('access-overlay').classList.add('show');
    // Re-trigger animation
    const bar = document.querySelector('.access-bar-fill');
    if (bar) { bar.style.animation='none'; bar.offsetHeight; bar.style.animation='fillBar 5s linear forwards'; }
}

/* ============================================================
   AUTH STATE — auto-detect returning user
============================================================ */
auth.onAuthStateChanged(user => {
    if (user) {
        currentUser = user;
        updateUIWithUser(user);
        loadPlanData(user.uid);
        // User already logged in — skip first screen, go to landing check
        document.getElementById('screen-first').classList.add('hide');
        setTimeout(() => { document.getElementById('screen-first').style.display='none'; }, 500);
        showLandingAndCheckAccess();
    }
    // else: show first screen — main-page stays hidden (visibility:hidden)
});

/* ============================================================
   LANDING + KEY CHECK
============================================================ */
function showLandingAndCheckAccess() {
    // Device ID
    let deviceId = localStorage.getItem('froxy_device_id');
    if (!deviceId) {
        const cookieMatch = document.cookie.match(/(^| )froxy_device_id=([^;]+)/);
        if (cookieMatch) deviceId = cookieMatch[2];
    }
    if (!deviceId) {
        const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        deviceId = Array.from({length:12},()=>chars[Math.floor(Math.random()*chars.length)]).join('');
    }
    localStorage.setItem('froxy_device_id', deviceId);
    document.cookie = "froxy_device_id=" + deviceId + "; max-age=315360000; path=/";

    document.getElementById('display-device-id').innerText = deviceId;

    const copyBtn = document.getElementById('copy-id-btn');
    if (copyBtn) {
        copyBtn.onclick = () => {
            navigator.clipboard.writeText(deviceId).then(() => {
                showToast('✅ Device ID Copied!');
            }).catch(() => { alert('Your ID: ' + deviceId); });
        };
    }

    // Check server status
    db.ref('server_status').on('value', (snap) => {
        const status = snap.val();
        if (status === false || status === 'offline') {
            document.getElementById('server-down-overlay').classList.add('active');
            return;
        }

        // Check approved_devices
        db.ref('approved_devices/' + deviceId).on('value', (snapshot) => {
            const data = snapshot.val();
            const landingPage = document.getElementById('landing-page');
            const getSubBtn = document.getElementById('get-sub-btn');

            if (!data) {
                document.getElementById('display-device-id').innerHTML = `${deviceId} <span style='color:#F59E0B;font-size:11px;margin-left:5px;'></span>`;
                landingPage.classList.add('show');
            } else if (data.status === 'active') {
                if (data.expiry && Date.now() > data.expiry) {
                    document.getElementById('display-device-id').innerHTML = `${deviceId} <span style='color:#EF4444;font-size:11px;margin-left:5px;'>(Expired)</span>`;
                    getSubBtn.innerHTML = `<svg viewBox="0 0 24 24" width="20" height="20" fill="#FFFFFF"><path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5zm14 3c0 .6-.4 1-1 1H6c-.6 0-1-.4-1-1v-1h14v1z"/></svg> Subscription Expired — Renew`;
                    landingPage.classList.add('show');
                } else {
                    // ACCESS GRANTED — animate button, 5s then go to main
                    document.getElementById('display-device-id').innerHTML = `${deviceId} <span style='color:#10B981;font-size:11px;margin-left:5px;'>✓ Active</span>`;
                    getSubBtn.style.background = 'linear-gradient(90deg,#10B981,#34D399)';
                    getSubBtn.style.boxShadow = '0 8px 18px rgba(16,185,129,0.4)';
                    getSubBtn.innerHTML = `<svg viewBox="0 0 24 24" width="20" height="20" fill="#FFFFFF"><path d="M20 6L9 17l-5-5"/></svg> Access Granted! Opening...`;
                    landingPage.classList.add('show');

                    // Populate plan data from approved_devices
                    applyPlanToProfile(data);

                    // 5 seconds then auto hide landing and show main
                    setTimeout(() => {
                        document.getElementById('main-page').classList.add('auth-ready');
                        landingPage.classList.add('hide-login');
                        setTimeout(() => { landingPage.style.display='none'; }, 500);
                    }, 5000);
                }
            } else {
                document.getElementById('display-device-id').innerHTML = `${deviceId} <span style='color:#F59E0B;font-size:11px;margin-left:5px;'>(Not Active)</span>`;
                getSubBtn.innerHTML = `<svg viewBox="0 0 24 24" width="20" height="20" fill="#FFFFFF"><path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5zm14 3c0 .6-.4 1-1 1H6c-.6 0-1-.4-1-1v-1h14v1z"/></svg> Contact Admin to Activate`;
                landingPage.classList.add('show');
            }
        });
    });
}

/* ============================================================
   LOGOUT
============================================================ */
async function handleLogout() {
    showLoading('Signing out...');
    try {
        await auth.signOut();
    } catch(e) { console.warn('signOut err:', e); }
    hideLoading();
    localStorage.removeItem('froxy_device_id');
    document.cookie = "froxy_device_id=; max-age=0; path=/";
    showToast('Signed out successfully.');
    location.reload();
}

/* ============================================================
   TABS
============================================================ */
function switchTab(tabName) {
    document.querySelectorAll('.tab-panel').forEach(p => { p.style.display='none'; p.classList.remove('active'); });
    document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
    const panel = document.getElementById('tab-'+tabName);
    if (panel) { panel.style.display = tabName==='plan'?'flex':'block'; panel.classList.add('active'); }
    const nav = document.querySelector('.nav-item[data-tab="'+tabName+'"]');
    if (nav) nav.classList.add('active');
    document.querySelector('.content-area').scrollTop = 0;
    if (tabName==='plan' && !planLoaded) { planLoaded=true; initPlanTab(); }
}

function initPlanTab() {
    const pageTitle = document.getElementById('plan-page-title');
    const loadingText = document.getElementById('plan-loading-text');
    const plansWrapper = document.getElementById('plans-wrapper');
    const mainBtn = document.getElementById('plan-main-btn');
    const statusBtn = document.getElementById('plan-status-btn');
    const carousel = document.getElementById('plan-carousel');
    setTimeout(() => {
        pageTitle.innerText = 'Manage Your Plan';
        loadingText.style.display = 'none';
        plansWrapper.style.display = 'flex';
        mainBtn.innerText = 'Renew — 299 ₹ 3 Days';
        mainBtn.classList.remove('btn-disabled');
        statusBtn.style.display = 'block';
        const firstCard = carousel.querySelector('.plan-card');
        if (firstCard) {
            const scrollAmount = firstCard.offsetWidth + 15;
            setTimeout(() => { carousel.scrollTo({left:scrollAmount,behavior:'smooth'});
                setTimeout(() => { carousel.scrollTo({left:scrollAmount*2,behavior:'smooth'});
                    setTimeout(() => { carousel.scrollTo({left:scrollAmount*3,behavior:'smooth'}); },900);
                },900);
            },500);
        }
    },3000);
}

/* ============================================================
   GAMES
============================================================ */
function selectGame(type) {
    selectedGame = type;
    document.getElementById('trx-card').classList.remove('active');
    document.getElementById('wingo-card').classList.remove('active');
    document.getElementById(type==='wingo'?'wingo-card':'trx-card').classList.add('active');
    const hs = document.getElementById('hidden-section');
    hs.style.display='block'; hs.classList.remove('animate-in'); void hs.offsetWidth; hs.classList.add('animate-in');
}

function togglePeriod() {
    const pv = document.getElementById('period-value');
    if (pv.innerText==='30 SEC') { pv.innerText='1 MIN'; selectedPeriod='1m'; }
    else { pv.innerText='30 SEC'; selectedPeriod='30s'; }
}

function connectGameURL() {
    const input = document.getElementById('game-url-input');
    const btn   = document.getElementById('connect-btn');
    let url = input.value.trim();
    if (!url) { input.focus(); input.style.borderColor='#e74c3c'; setTimeout(()=>input.style.borderColor='#e1e3e6',1500); return; }
    if (!url.startsWith('http://') && !url.startsWith('https://')) url='https://'+url;
    btn.textContent='✓ Connected'; btn.classList.add('connected'); btn.onclick=null;
    document.getElementById('game-iframe').src=url;
    setTimeout(()=>{ openWebviewPage(); },400);
}

function openWebviewPage() {
    document.getElementById('main-page').classList.add('slide-out');
    document.getElementById('webview-page').classList.add('slide-in');
}

function closeWebviewPage() {
    document.getElementById('webview-page').classList.remove('slide-in');
    document.getElementById('main-page').classList.remove('slide-out');
    const btn=document.getElementById('connect-btn');
    btn.textContent='Connect'; btn.classList.remove('connected'); btn.onclick=connectGameURL;
    document.getElementById('game-url-input').value='';
    document.getElementById('game-url-input').style.borderColor='#e1e3e6';
    document.getElementById('game-iframe').src='';
    document.getElementById('wvLargeSheet').classList.remove('active');
    document.getElementById('wvSheetBackdrop').classList.remove('active');
    document.getElementById('wvActionMenu').classList.remove('active');
    document.getElementById('wvFabContainer').classList.remove('hidden');
    stopHackTimer(); hideInjector();
}

/* FAB & SHEETS */
document.getElementById('wvOpenMenuBtn').addEventListener('click',()=>{
    document.getElementById('wvFabContainer').classList.add('hidden');
    document.getElementById('wvActionMenu').classList.add('active');
});
document.getElementById('wvCloseMenuBtn').addEventListener('click',()=>{
    document.getElementById('wvActionMenu').classList.remove('active');
    document.getElementById('wvLargeSheet').classList.remove('active');
    document.getElementById('wvSheetBackdrop').classList.remove('active');
    document.getElementById('wvFabContainer').classList.remove('hidden');
    stopHackTimer();
});
document.getElementById('wvHackBtn').addEventListener('click',()=>{
    document.getElementById('wvActionMenu').classList.remove('active');
    document.getElementById('wvSheetTitle').innerText='HACK';
    renderHackSheet();
    document.getElementById('wvLargeSheet').classList.add('active');
    document.getElementById('wvSheetBackdrop').classList.add('active');
    startHackTimer();
});
document.getElementById('wvSettingBtn').addEventListener('click',()=>{
    document.getElementById('wvActionMenu').classList.remove('active');
    document.getElementById('wvSheetTitle').innerText='SETTING';
    renderSettingSheet();
    document.getElementById('wvLargeSheet').classList.add('active');
    document.getElementById('wvSheetBackdrop').classList.add('active');
    stopHackTimer();
});
document.getElementById('wvSheetBackdrop').addEventListener('click',()=>{
    document.getElementById('wvLargeSheet').classList.remove('active');
    document.getElementById('wvSheetBackdrop').classList.remove('active');
    document.getElementById('wvActionMenu').classList.remove('active');
    document.getElementById('wvFabContainer').classList.remove('hidden');
    stopHackTimer();
});

/* PERIOD & CONFIDENCE */
function getPeriodAndTimer() {
    const now = new Date();
    if (selectedPeriod === '1m') {
        const utcSeconds=now.getUTCSeconds(), utcMinutes=now.getUTCMinutes(), utcHours=now.getUTCHours();
        const remainingSeconds=60-utcSeconds, totalMinutes=utcHours*60+utcMinutes;
        const dateStr=now.getUTCFullYear().toString()+String(now.getUTCMonth()+1).padStart(2,'0')+String(now.getUTCDate()).padStart(2,'0');
        const periodId=dateStr+'1000'+(10001+totalMinutes);
        return { periodId, remainingSeconds, totalSeconds:remainingSeconds };
    } else {
        const istOffset=5.5*60*60*1000, ist=new Date(now.getTime()+istOffset);
        const istH=ist.getUTCHours(), istM=ist.getUTCMinutes(), istS=ist.getUTCSeconds();
        let elapsed=(istH*3600+istM*60+istS)-(5*3600+30*60);
        if (elapsed<0) elapsed=0;
        const upcomingPeriod=Math.floor(elapsed/30)+1;
        const dateStr=ist.getUTCFullYear().toString()+String(ist.getUTCMonth()+1).padStart(2,'0')+String(ist.getUTCDate()).padStart(2,'0');
        const periodId=dateStr+'100005'+String(upcomingPeriod).padStart(4,'0');
        const remainingSeconds=30-(istS%30);
        return { periodId, remainingSeconds, totalSeconds:remainingSeconds };
    }
}

function getConfidence() {
    const base=[65,72,58,80,51,70,63,76,55,68];
    const { periodId }=getPeriodAndTimer();
    return base[parseInt(periodId.slice(-2))%base.length];
}
function getLevelFill() { return hackLevel==='L1'?65:hackLevel==='L2'?35:20; }
function getTimerFill(rem,total) { return Math.round((rem/total)*100); }

/* ============================================================
   NARUTO STYLE PREDICTION ENGINE (big/small)
============================================================ */
function getNarutoPrediction(periodId) {
    // Use periodId to generate deterministic but dynamic prediction
    const seed = parseInt(periodId.slice(-4)) || 0;
    const day = parseInt(periodId.slice(0,8)) || 0;
    const hour = parseInt(periodId.slice(8,10)) || 0;
    const minute = parseInt(periodId.slice(10,12)) || 0;
    
    // Complex calculation mixing multiple factors
    const raw = (seed * 7 + day * 3 + hour * 11 + minute * 5) % 100;
    const confidence = 60 + (raw % 35);
    const isBig = raw > 45;
    
    return {
        isBig: isBig,
        confidence: Math.min(95, confidence),
        number: isBig ? 5 + (raw % 5) : (raw % 5)
    };
}

function getPredictionImg() {
    const { periodId } = getPeriodAndTimer();
    if (shownPredictions[periodId]) {
        return shownPredictions[periodId] === 'big' ? PNG_BIG : PNG_SMALL;
    }
    const pred = getNarutoPrediction(periodId);
    shownPredictions[periodId] = pred.isBig ? 'big' : 'small';
    const keys = Object.keys(shownPredictions);
    if (keys.length > 10) delete shownPredictions[keys[0]];
    return pred.isBig ? PNG_BIG : PNG_SMALL;
}

function getPredictionText() {
    const { periodId } = getPeriodAndTimer();
    const pred = getNarutoPrediction(periodId);
    return pred.isBig ? 'BIG' : 'SMALL';
}

function getPredictionNumber() {
    const { periodId } = getPeriodAndTimer();
    const pred = getNarutoPrediction(periodId);
    return pred.number;
}

function getPredictionConfidence() {
    const { periodId } = getPeriodAndTimer();
    const pred = getNarutoPrediction(periodId);
    return pred.confidence;
}

/* HACK SHEET */
function renderHackSheet() {
    const body = document.getElementById('wvSheetBody');
    const conf = getPredictionConfidence();
    const lvlFill = getLevelFill();
    const { periodId, remainingSeconds } = getPeriodAndTimer();
    const timerFill = getTimerFill(remainingSeconds, selectedPeriod === '30s' ? 30 : 60);
    const predImg = getPredictionImg();
    const timerStr = String(remainingSeconds).padStart(2, '0') + 's';
    
    body.innerHTML = `<div class="hack-container">
        <img src="${predImg}" alt="Prediction" class="hack-header-logo" id="hackResultImg">
        <div class="period-badge-hack"># PERIOD : ${periodId}</div>
        <div class="hack-main-card">
            <div class="confidence-header"><span class="confidence-label">CONFIDENCE</span><span class="confidence-value" id="hackConfVal">${conf}%</span></div>
            <div class="progress-track"><div class="progress-fill" id="hackProgFill" style="width:${conf}%"></div></div>
            <div class="stats-row">
                <div class="stat-item">
                    <div class="circle-chart" id="hackLvlChart" style="background:conic-gradient(#554e7d 0% ${lvlFill}%,#d8dbe5 ${lvlFill}% 100%)">
                        <div class="circle-inner"><span class="inner-text" id="hackLvlText"><span class="target-icon"></span>${hackLevel}</span></div>
                    </div><span class="stat-label">LEVEL</span>
                </div>
                <div class="stat-item">
                    <div class="circle-chart" id="hackWinRateChart" style="background:conic-gradient(#554e7d 0% ${Math.min(hackWinRate,100)}%,#d8dbe5 ${Math.min(hackWinRate,100)}% 100%)">
                        <div class="circle-inner"><span class="inner-text" id="hackWinRateVal">${hackWinRate}%</span></div>
                    </div><span class="stat-label">WIN RATE</span>
                </div>
                <div class="stat-item">
                    <div class="circle-chart" id="hackTimerChart" style="background:conic-gradient(#554e7d 0% ${timerFill}%,#d8dbe5 ${timerFill}% 100%)">
                        <div class="circle-inner"><span class="inner-text" id="hackTimerText">${timerStr}</span></div>
                    </div><span class="stat-label">TIMER</span>
                </div>
            </div>
        </div>
        <div class="sheet-footer-txt" style="margin-top:20px;">
            <svg viewBox="0 0 24 24"><path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46C19.54 15.03 20 13.57 20 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74C4.46 8.97 4 10.43 4 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z"/></svg>
            Naruto-style AI · Real-time pattern analysis
        </div>
    </div>`;
}

function startHackTimer() {
    stopHackTimer();
    hackTimerInterval = setInterval(() => {
        const { periodId, remainingSeconds } = getPeriodAndTimer();
        const total = selectedPeriod === '30s' ? 30 : 60;
        const timerFill = Math.round((remainingSeconds / total) * 100);
        const timerText = document.getElementById('hackTimerText');
        const timerChart = document.getElementById('hackTimerChart');
        const periodBadge = document.querySelector('.period-badge-hack');
        const confEl = document.getElementById('hackConfVal');
        const progFill = document.getElementById('hackProgFill');
        
        if (timerText) timerText.textContent = String(remainingSeconds).padStart(2, '0') + 's';
        if (timerChart) timerChart.style.background = `conic-gradient(#554e7d 0% ${timerFill}%,#d8dbe5 ${timerFill}% 100%)`;
        if (periodBadge) periodBadge.textContent = '# PERIOD : ' + periodId;
        
        const conf = getPredictionConfidence();
        if (confEl) confEl.textContent = conf + '%';
        if (progFill) progFill.style.width = conf + '%';
        
        const winRateEl = document.getElementById('hackWinRateVal');
        const winRateChart = document.getElementById('hackWinRateChart');
        if (winRateEl) winRateEl.textContent = hackWinRate + '%';
        if (winRateChart) {
            const fill = Math.min(hackWinRate, 100);
            winRateChart.style.background = `conic-gradient(#554e7d 0% ${fill}%,#d8dbe5 ${fill}% 100%)`;
        }
        
        if (lastCheckedPeriod && lastCheckedPeriod !== periodId) {
            showTransitionPNG(lastCheckedPeriod);
        }
        lastCheckedPeriod = periodId;
        
        const imgEl = document.getElementById('hackResultImg');
        if (imgEl && !resultPngShowing) imgEl.src = getPredictionImg();
        
        const lvlChart = document.getElementById('hackLvlChart');
        const lvlText = document.getElementById('hackLvlText');
        const lvlFill = getLevelFill();
        if (lvlChart) lvlChart.style.background = `conic-gradient(#554e7d 0% ${lvlFill}%,#d8dbe5 ${lvlFill}% 100%)`;
        if (lvlText) lvlText.innerHTML = `<span class="target-icon"></span>${hackLevel}`;
    }, 1000);
}

function stopHackTimer() {
    if (hackTimerInterval) {
        clearInterval(hackTimerInterval);
        hackTimerInterval = null;
    }
}

function showTransitionPNG(oldPeriod) {
    const imgEl = document.getElementById('hackResultImg');
    if (!imgEl) return;
    resultPngShowing = true;
    imgEl.src = PNG_LOADING;
    setTimeout(() => {
        silentFetchResult(oldPeriod).then(result => {
            hackTotalBets++;
            if (result === 'win') {
                hackWinRate = Math.min(100, hackWinRate + 5);
                if (hackLevel === 'L1') hackLevel = 'L2';
                else if (hackLevel === 'L2') hackLevel = 'L3';
            } else if (result === 'loss') {
                const dec = parseFloat((Math.random() * 3 + 2).toFixed(1));
                hackWinRate = Math.max(60, parseFloat((hackWinRate - dec).toFixed(1)));
                hackLevel = 'L1';
            }
            const winRateEl = document.getElementById('hackWinRateVal');
            const winRateChart = document.getElementById('hackWinRateChart');
            if (winRateEl) winRateEl.textContent = hackWinRate + '%';
            if (winRateChart) {
                const fill = Math.min(hackWinRate, 100);
                winRateChart.style.background = `conic-gradient(#554e7d 0% ${fill}%,#d8dbe5 ${fill}% 100%)`;
            }
            const lvlChart = document.getElementById('hackLvlChart');
            const lvlText = document.getElementById('hackLvlText');
            const lvlFill = getLevelFill();
            if (lvlChart) lvlChart.style.background = `conic-gradient(#554e7d 0% ${lvlFill}%,#d8dbe5 ${lvlFill}% 100%)`;
            if (lvlText) lvlText.innerHTML = `<span class="target-icon"></span>${hackLevel}`;
            if (imgEl) imgEl.src = getPredictionImg();
            resultPngShowing = false;
        });
    }, 3000);
}

async function silentFetchResult(periodId) {
    try {
        const ts = Date.now();
        const url = selectedPeriod === '30s'
            ? `https://draw.ar-lottery01.com/WinGo/WinGo_30S/GetHistoryIssuePage.json?ts=${ts}`
            : `https://draw.ar-lottery01.com/WinGo/WinGo_1M/GetHistoryIssuePage.json?ts=${ts}`;
        const resp = await fetch(url);
        const data = await resp.json();
        const list = data?.data?.list;
        if (!list || !list.length) return 'unknown';
        const item = list.find(r => String(r.issueNumber) === String(periodId) || String(r.period) === String(periodId)) || list[0];
        if (!item) return 'unknown';
        const actualNum = parseInt(item.number ?? item.openCode ?? item.winningNumber ?? 0);
        const actualBig = actualNum >= 5;
        const hackPrediction = shownPredictions[periodId];
        if (!hackPrediction) return 'unknown';
        return (hackPrediction === 'big') === actualBig ? 'win' : 'loss';
    } catch (e) {
        return 'unknown';
    }
}

/* SETTING SHEET */
function renderSettingSheet() {
    const body = document.getElementById('wvSheetBody');
    const currentServer = window._selectedServer || 'nova';
    const predType = window._predType || 'bigsmall';
    body.innerHTML = `<div class="setting-container">
        <div class="premium-banner-s">
            <svg class="icon-star-s" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1.5C12 7.5 16.5 12 22.5 12C16.5 12 12 16.5 12 22.5C12 16.5 7.5 12 1.5 12C7.5 12 12 7.5 12 1.5Z"/></svg>
            <div class="premium-text-s">I WANT TO USE MY<br>PREMIUM SERVER</div>
        </div>
        <div class="active-server-card">
            <div class="asc-check"><svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></div>
            <div class="asc-info">
                <div class="asc-name">BLZ Prime Pro v2</div>
                <div class="asc-sub">PREMIUM ACTIVE · custom</div>
            </div>
            <button class="asc-remove" onclick="selectServerS('none')">Remove</button>
        </div>
        <div class="pred-type-row">
            <div class="pred-btn ${predType === 'greenred' ? 'active-pred' : ''}" onclick="setPredType('greenred',this)">GREEN / RED</div>
            <div class="pred-btn ${predType === 'bigsmall' ? 'active-pred' : ''}" onclick="setPredType('bigsmall',this)">BIG / SMALL</div>
        </div>
        <div class="section-title-s">AVAILABLE SERVERS <span class="paid-badge-s">PAID</span></div>
        <div class="servers-grid-s">
            <div class="server-card-s ${currentServer === 'prime' ? 'active-s' : ''}" id="card-prime-s" onclick="selectServerS('prime')">
                <svg class="s-icon" viewBox="0 0 100 100" fill="none">
                    <polygon points="50,5 62,35 95,35 70,57 80,90 50,70 20,90 30,57 5,35 38,35" fill="#9b7fe8" opacity="0.25"/>
                    <polygon points="50,15 59,38 84,38 64,54 72,78 50,63 28,78 36,54 16,38 41,38" fill="#7c5cbf" opacity="0.6"/>
                    <polygon points="50,28 56,44 73,44 60,54 65,70 50,61 35,70 40,54 27,44 44,44" fill="#4a3580"/>
                </svg>
                <div class="server-name-s">PRIME</div>
            </div>
            <div class="server-card-s ${currentServer === 'nova' ? 'active-s' : ''}" id="card-nova-s" onclick="selectServerS('nova')">
                <svg class="s-icon" viewBox="0 0 100 100" fill="none">
                    <path d="M50 10 C52 25,62 30,80 32 C62 34,52 40,50 55 C48 40,38 34,20 32 C38 30,48 25,50 10Z" fill="#c9baff" opacity="0.4"/>
                    <path d="M50 20 C52 32,60 36,75 38 C60 40,52 44,50 56 C48 44,40 40,25 38 C40 36,48 32,50 20Z" fill="#9b7fe8" opacity="0.7"/>
                    <circle cx="50" cy="38" r="8" fill="#4a3580"/>
                    <circle cx="50" cy="38" r="4" fill="#e8e2ff"/>
                    <path d="M50 10 L52 18 M50 66 L52 58 M10 38 L18 40 M90 38 L82 40" stroke="#9b7fe8" stroke-width="2" stroke-linecap="round" opacity="0.5"/>
                </svg>
                <div class="server-name-s">NOVA</div>
            </div>
        </div>
        <div class="injector-section-s">
            <div class="injector-text-s">INJECTOR</div>
            <label class="toggle-switch-s">
                <input type="checkbox" id="injectorToggleS" onchange="handleInjectorToggle(this.checked)" ${injectorActive ? 'checked' : ''}>
                <span class="slider-s"></span>
            </label>
        </div>
        <div class="sheet-footer-txt">
            <svg viewBox="0 0 24 24"><path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46C19.54 15.03 20 13.57 20 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74C4.46 8.97 4 10.43 4 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z"/></svg>
            Premium server auto-switches on best performance
        </div>
    </div>`;
}

function selectServerS(id) {
    window._selectedServer = id;
    document.querySelectorAll('.server-card-s').forEach(c => c.classList.remove('active-s'));
    const el = document.getElementById('card-' + id + '-s');
    if (el) el.classList.add('active-s');
}
function setPredType(type, el) {
    window._predType = type;
    document.querySelectorAll('.pred-btn').forEach(b => b.classList.remove('active-pred'));
    if (el) el.classList.add('active-pred');
}

/* INJECTOR */
function handleInjectorToggle(checked) {
    injectorActive = checked;
    if (checked) {
        document.getElementById('wvLargeSheet').classList.remove('active');
        document.getElementById('wvSheetBackdrop').classList.remove('active');
        document.getElementById('wvFabContainer').classList.add('hidden');
        stopHackTimer();
        showInjectorFloatLogo();
    } else {
        hideInjector();
    }
}

function showInjectorFloatLogo() {
    const overlay = document.getElementById('injector-overlay');
    const floatLogo = document.getElementById('inj-float-logo');
    const modal = document.getElementById('inj-modal');
    overlay.classList.add('active');
    floatLogo.style.display = 'block';
    modal.style.display = 'none';
    floatLogo.style.top = '50%';
    floatLogo.style.left = '50%';
    floatLogo.style.transform = 'translate(-50%,-50%)';
}

function openInjectorModal() {
    const floatLogo = document.getElementById('inj-float-logo');
    const modal = document.getElementById('inj-modal');
    floatLogo.style.display = 'none';
    modal.style.display = 'block';
    modal.style.top = '50%';
    modal.style.left = '50%';
    modal.style.transform = 'translate(-50%,-50%)';
    startInjTimer();
    updateInjPeriodDisplay();
}

function closeInjectorModal() {
    const floatLogo = document.getElementById('inj-float-logo');
    const modal = document.getElementById('inj-modal');
    modal.style.display = 'none';
    floatLogo.style.display = 'block';
    stopInjTimer();
    injResultShowing = false;
    resetInjResult();
}

function hideInjector() {
    document.getElementById('injector-overlay').classList.remove('active');
    document.getElementById('inj-float-logo').style.display = 'none';
    document.getElementById('inj-modal').style.display = 'none';
    injectorActive = false;
    stopInjTimer();
    injResultShowing = false;
    resetInjResult();
}

function startInjTimer() {
    stopInjTimer();
    injTimerInterval = setInterval(updateInjPeriodDisplay, 1000);
}
function stopInjTimer() {
    if (injTimerInterval) {
        clearInterval(injTimerInterval);
        injTimerInterval = null;
    }
}

function updateInjPeriodDisplay() {
    const { periodId, remainingSeconds } = getPeriodAndTimer();
    const pEl = document.getElementById('injPeriodNum');
    const tEl = document.getElementById('injTimeRem');
    if (pEl) pEl.textContent = periodId;
    if (tEl) {
        const mins = Math.floor(remainingSeconds / 60);
        const secs = remainingSeconds % 60;
        tEl.textContent = mins > 0 ? mins + ':' + String(secs).padStart(2, '0') : '0:' + String(secs).padStart(2, '0');
    }
    if (injCurrentClickedPeriod && injCurrentClickedPeriod !== periodId) {
        injResultShowing = false;
        injCurrentClickedPeriod = null;
        resetInjResult();
    }
}

function injRow1Change(el) {
    injRow1Selected = el.value;
    hideInjNotice();
    if (injResultShowing) updateInjPrediction();
}
function injRow2Change(el) {
    injRow2Selected = el.value;
    hideInjNotice();
    if (injResultShowing) updateInjPrediction();
}
function hideInjNotice() {
    const n = document.getElementById('injNotice');
    if (n) n.style.display = 'none';
}
function showInjNotice() {
    const n = document.getElementById('injNotice');
    if (n) {
        n.style.display = 'block';
        setTimeout(() => { n.style.display = 'none'; }, 3000);
    }
}

document.getElementById('injGetBtn').addEventListener('click', () => {
    if (!injRow1Selected || !injRow2Selected) {
        showInjNotice();
        return;
    }
    const { periodId } = getPeriodAndTimer();
    if (injCurrentClickedPeriod === periodId && injResultShowing) {
        updateInjPrediction();
        return;
    }
    const loadingEl = document.getElementById('injLoading');
    const predBox = document.getElementById('injPredBox');
    const resultArea = document.getElementById('injResultArea');
    const getBtn = document.getElementById('injGetBtn');
    
    predBox.style.display = 'none';
    resultArea.style.display = 'none';
    loadingEl.style.display = 'flex';
    getBtn.style.opacity = '0.5';
    getBtn.style.pointerEvents = 'none';
    
    setTimeout(() => {
        loadingEl.style.display = 'none';
        getBtn.style.opacity = '1';
        getBtn.style.pointerEvents = 'auto';
        injResultShowing = true;
        injCurrentClickedPeriod = periodId;
        updateInjPrediction();
        predBox.style.display = 'flex';
        if (injRow1Selected === 'number') resultArea.style.display = 'block';
        else resultArea.style.display = 'none';
    }, 3000);
});

function updateInjPrediction() {
    const { periodId } = getPeriodAndTimer();
    const conf = getPredictionConfidence();
    const pred = getPredictionText();
    const num = getPredictionNumber();
    
    if (injRow1Selected === 'bigsmall') {
        document.getElementById('injPredText').textContent = pred;
        document.getElementById('injConfText').textContent = conf + '%';
        document.getElementById('injResultArea').style.display = 'none';
    } else if (injRow1Selected === 'redgreen') {
        document.getElementById('injPredText').textContent = pred === 'BIG' ? 'RED' : 'GREEN';
        document.getElementById('injConfText').textContent = conf + '%';
        document.getElementById('injResultArea').style.display = 'none';
    } else if (injRow1Selected === 'number') {
        document.getElementById('injPredText').textContent = '—';
        document.getElementById('injConfText').textContent = conf + '%';
        document.getElementById('injResultNumber').textContent = num;
        document.getElementById('injResultArea').style.display = 'block';
    }
    if (injResultShowing) document.getElementById('injConfText').textContent = conf + '%';
}

function resetInjResult() {
    document.getElementById('injPredText').textContent = '—';
    document.getElementById('injConfText').textContent = '—';
    document.getElementById('injResultArea').style.display = 'none';
    document.getElementById('injLoading').style.display = 'none';
    document.getElementById('injPredBox').style.display = 'flex';
    document.getElementById('injGetBtn').style.opacity = '1';
    document.getElementById('injGetBtn').style.pointerEvents = 'auto';
}

let injLogoIsDragging = false;
document.getElementById('inj-float-logo').addEventListener('click', () => {
    if (!injLogoIsDragging) openInjectorModal();
});
document.getElementById('injCloseBtn').addEventListener('click', () => {
    closeInjectorModal();
});

function makeElementDraggable(el, handle, onDragStart, onDragEnd) {
    let isDragging = false, startX, startY, origLeft, origTop;
    handle = handle || el;
    function getCoords(e) {
        return e.touches ? { x: e.touches[0].clientX, y: e.touches[0].clientY } : { x: e.clientX, y: e.clientY };
    }
    function onDown(e) {
        if (e.target.tagName === 'INPUT' || e.target.classList.contains('inj-close-btn') || 
            e.target.classList.contains('inj-radio-label') || e.target.classList.contains('inj-get-btn')) return;
        isDragging = false;
        const c = getCoords(e);
        startX = c.x;
        startY = c.y;
        const rect = el.getBoundingClientRect();
        const parentRect = el.parentElement.getBoundingClientRect();
        origLeft = rect.left - parentRect.left;
        origTop = rect.top - parentRect.top;
        el.style.transform = 'none';
        el.style.left = origLeft + 'px';
        el.style.top = origTop + 'px';
        document.addEventListener('mousemove', onMove);
        document.addEventListener('touchmove', onMove, { passive: false });
        document.addEventListener('mouseup', onUp);
        document.addEventListener('touchend', onUp);
    }
    function onMove(e) {
        if (e.cancelable) e.preventDefault();
        const c = getCoords(e);
        const dx = c.x - startX;
        const dy = c.y - startY;
        if (Math.abs(dx) > 4 || Math.abs(dy) > 4) isDragging = true;
        if (!isDragging) return;
        if (onDragStart) onDragStart();
        const parentRect = el.parentElement.getBoundingClientRect();
        let newL = origLeft + dx;
        let newT = origTop + dy;
        const margin = 8;
        newL = Math.max(margin, Math.min(parentRect.width - el.offsetWidth - margin, newL));
        newT = Math.max(margin, Math.min(parentRect.height - el.offsetHeight - margin, newT));
        el.style.left = newL + 'px';
        el.style.top = newT + 'px';
    }
    function onUp() {
        document.removeEventListener('mousemove', onMove);
        document.removeEventListener('touchmove', onMove);
        document.removeEventListener('mouseup', onUp);
        document.removeEventListener('touchend', onUp);
        if (onDragEnd) setTimeout(() => { onDragEnd(isDragging); isDragging = false; }, 50);
    }
    handle.addEventListener('mousedown', onDown);
    handle.addEventListener('touchstart', onDown, { passive: false });
}

makeElementDraggable(document.getElementById('inj-float-logo'), null, () => {
    injLogoIsDragging = true;
}, (wasDragging) => {
    if (!wasDragging) injLogoIsDragging = false;
    else setTimeout(() => { injLogoIsDragging = false; }, 200);
});
makeElementDraggable(document.getElementById('inj-modal'), document.getElementById('inj-modal-header'), null, null);
</script>
</body>
</html>