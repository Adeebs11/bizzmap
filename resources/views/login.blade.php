<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — BizzMap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/stylelogin.css') }}">
</head>
<body>
@include('partials.loading-screen')

{{-- BACKGROUND --}}
<div class="login-bg"></div>
<div class="login-overlay"></div>
<div class="decor-ring ring-1"></div>
<div class="decor-ring ring-2"></div>

{{-- MAIN CONTENT --}}
<div class="login-main">

    {{-- KIRI: Brand --}}
    <div class="login-left">
        <div class="brand-logo">
            <div class="brand-icon">
                <i class="fa-solid fa-map-location-dot"></i>
            </div>
            <span class="brand-name">BizzMap</span>
        </div>
        <p class="brand-tagline">PT Telkom Indonesia — Branch Jambi</p>
        <h1 class="brand-headline">Pemetaan segmen<br>pelanggan Indibiz</h1>
        <p class="brand-sub">Platform GIS untuk mendukung tim Sales
        dalam memetakan dan menganalisis potensi pelanggan
        di Kota Jambi.</p>
        <div class="brand-divider"></div>
    </div>

    {{-- KANAN: Form Login --}}
    <div class="login-right">
        <div class="login-card">
            <p class="card-eyebrow">Masuk ke sistem</p>
            <h2 class="card-title">Login</h2>

            @if ($errors->any())
            <div class="error-box">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-field">
                    <label class="field-label" for="email">Email</label>
                    <div class="field-wrapper">
                        <i class="fa-regular fa-envelope field-icon"
                           aria-hidden="true"></i>
                        <input type="email"
                               id="email"
                               name="email"
                               class="field-input"
                               placeholder="nama@telkom.co.id"
                               value="{{ old('email') }}"
                               required>
                    </div>
                </div>

                <div class="form-field">
                    <label class="field-label" for="password">Password</label>
                    <div class="field-wrapper">
                        <i class="fa-solid fa-lock field-icon"
                           aria-hidden="true"></i>
                        <input type="password"
                               id="password"
                               name="password"
                               class="field-input"
                               placeholder="••••••••"
                               required>
                    </div>
                </div>

                <button type="submit" class="btn-login-new">
                    Masuk
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </button>
            </form>

            <div class="card-footer-new">
                <div class="footer-badge">
                    <i class="fa-solid fa-building" aria-hidden="true"></i>
                    <span>Indibiz by Telkom Indonesia</span>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- FOOTER ILUSTRASI PANORAMA KOTA --}}
<div class="login-footer">
    <svg viewBox="0 0 1200 130"
         xmlns="http://www.w3.org/2000/svg"
         preserveAspectRatio="xMidYMax meet">

        <!-- Base -->
        <rect x="0" y="0" width="1200" height="130"
              fill="rgba(8,14,30,0.65)"/>
        <rect x="0" y="90"  width="1200" height="40"
              fill="#0a1220"/>
        <rect x="0" y="100" width="1200" height="18"
              fill="#111c35"/>
        <line x1="0" y1="109" x2="1200" y2="109"
              stroke="rgba(255,255,255,0.12)"
              stroke-width="1.5" class="road-line"/>

        <!-- Stars -->
        <circle cx="100"  cy="12" r="1"   fill="rgba(255,255,255,.4)"/>
        <circle cx="250"  cy="8"  r="1.2" fill="rgba(255,255,255,.3)"/>
        <circle cx="500"  cy="15" r="0.9" fill="rgba(255,255,255,.5)"/>
        <circle cx="750"  cy="6"  r="1"   fill="rgba(255,255,255,.35)"/>
        <circle cx="950"  cy="11" r="1.2" fill="rgba(255,255,255,.4)"/>
        <circle cx="1100" cy="18" r="1"   fill="rgba(255,255,255,.3)"/>

        <!-- Cloud A -->
        <g class="cloud-a">
            <ellipse cx="180" cy="22" rx="40" ry="13"
                     fill="rgba(255,255,255,.05)"/>
            <ellipse cx="162" cy="27" rx="24" ry="10"
                     fill="rgba(255,255,255,.04)"/>
            <ellipse cx="200" cy="27" rx="20" ry="9"
                     fill="rgba(255,255,255,.04)"/>
        </g>
        <!-- Cloud B -->
        <g class="cloud-b">
            <ellipse cx="900" cy="18" rx="50" ry="14"
                     fill="rgba(255,255,255,.04)"/>
            <ellipse cx="878" cy="24" rx="28" ry="10"
                     fill="rgba(255,255,255,.035)"/>
            <ellipse cx="924" cy="24" rx="24" ry="9"
                     fill="rgba(255,255,255,.035)"/>
        </g>

        <!-- Bld 1 far left -->
        <g class="bld bld1">
            <rect x="30" y="38" width="28" height="55"
                  fill="#162440" rx="2"/>
            <rect x="34" y="43" width="5" height="7"
                  fill="rgba(255,220,100,.5)" rx="1"/>
            <rect x="43" y="43" width="5" height="7"
                  fill="rgba(255,220,100,.3)" rx="1"/>
            <rect x="34" y="55" width="5" height="7"
                  fill="rgba(255,220,100,.4)" rx="1"/>
            <rect x="43" y="55" width="5" height="7"
                  fill="rgba(255,220,100,.6)" rx="1"/>
            <rect x="34" y="67" width="5" height="7"
                  fill="rgba(255,220,100,.3)" rx="1"/>
        </g>

        <!-- Bld 2 left tall -->
        <g class="bld bld2">
            <rect x="72" y="18" width="40" height="75"
                  fill="#1a2d55" rx="2"/>
            <rect x="76" y="24" width="7" height="9"
                  fill="rgba(255,220,100,.6)" rx="1"/>
            <rect x="87" y="24" width="7" height="9"
                  fill="rgba(255,220,100,.3)" rx="1"/>
            <rect x="98" y="24" width="7" height="9"
                  fill="rgba(255,220,100,.5)" rx="1"/>
            <rect x="76" y="39" width="7" height="9"
                  fill="rgba(255,220,100,.4)" rx="1"/>
            <rect x="87" y="39" width="7" height="9"
                  fill="rgba(255,220,100,.6)" rx="1"/>
            <rect x="98" y="39" width="7" height="9"
                  fill="rgba(255,220,100,.3)" rx="1"/>
            <rect x="76" y="54" width="7" height="9"
                  fill="rgba(255,220,100,.5)" rx="1"/>
            <rect x="98" y="54" width="7" height="9"
                  fill="rgba(255,220,100,.4)" rx="1"/>
            <rect x="76" y="69" width="7" height="9"
                  fill="rgba(255,220,100,.3)" rx="1"/>
            <rect x="87" y="69" width="7" height="9"
                  fill="rgba(255,220,100,.5)" rx="1"/>
            <line x1="92" y1="18" x2="92" y2="8"
                  stroke="#C02016" stroke-width="1.5"/>
            <circle cx="92" cy="7" r="2.5" fill="#C02016"/>
            <circle cx="92" cy="7" r="8" fill="none"
                    stroke="rgba(192,32,22,.3)"
                    stroke-width="1" class="ant-ring">
                <animate attributeName="r"
                         values="4;14;4"
                         dur="2s" repeatCount="indefinite"/>
                <animate attributeName="opacity"
                         values="0.5;0;0.5"
                         dur="2s" repeatCount="indefinite"/>
            </circle>
        </g>

        <!-- Bld 3 left short -->
        <g class="bld bld3">
            <rect x="122" y="55" width="24" height="38"
                  fill="#1e2e50" rx="2"/>
            <rect x="126" y="60" width="5" height="7"
                  fill="rgba(255,220,100,.4)" rx="1"/>
            <rect x="135" y="60" width="5" height="7"
                  fill="rgba(255,220,100,.6)" rx="1"/>
            <rect x="126" y="72" width="5" height="7"
                  fill="rgba(255,220,100,.3)" rx="1"/>
            <rect x="135" y="72" width="5" height="7"
                  fill="rgba(255,220,100,.5)" rx="1"/>
        </g>

        <!-- Pin A -->
        <g class="pin-a" style="transform-origin:270px 75px">
            <circle cx="270" cy="75" r="8"
                    fill="rgba(192,32,22,.15)"
                    stroke="rgba(192,32,22,.3)"
                    stroke-width="1"/>
            <circle cx="270" cy="75" r="3.5" fill="#C02016"/>
        </g>

        <!-- CHARACTER -->
        <g class="char-grp">
            <ellipse cx="310" cy="98" rx="16" ry="3.5"
                     fill="rgba(0,0,0,.35)"/>
            <rect x="297" y="64" width="26" height="30"
                  fill="#C02016" rx="5"/>
            <polygon points="306,64 317,64 311,73"
                     fill="white" opacity=".9"/>
            <rect x="287" y="66" width="10" height="22"
                  fill="#C02016" rx="4"/>
            <rect x="323" y="66" width="10" height="18"
                  fill="#C02016" rx="4"/>
            <circle cx="292" cy="89" r="4.5" fill="#f4c49e"/>
            <circle cx="328" cy="85" r="4.5" fill="#f4c49e"/>
            <rect x="322" y="74" width="17" height="13"
                  fill="#1a2d55" rx="2.5"/>
            <rect x="324" y="76" width="13" height="9"
                  fill="#0d3060" rx="1.5"/>
            <circle cx="330" cy="80" r="1.8"
                    fill="#C02016" opacity=".8"/>
            <g class="wifi-anim">
                <path d="M337,77 Q339,74 341,77"
                      stroke="#378ADD" stroke-width="1"
                      fill="none" stroke-linecap="round"/>
                <path d="M335,80 Q339,74 343,80"
                      stroke="#378ADD" stroke-width=".8"
                      fill="none" stroke-linecap="round"
                      opacity=".5"/>
            </g>
            <rect x="299" y="92" width="10" height="16"
                  fill="#1a2d55" rx="3"/>
            <rect x="312" y="92" width="10" height="16"
                  fill="#1a2d55" rx="3"/>
            <rect x="297" y="105" width="12" height="6"
                  fill="#0d1a3a" rx="2.5"/>
            <rect x="311" y="105" width="12" height="6"
                  fill="#0d1a3a" rx="2.5"/>
            <rect x="307" y="57" width="7" height="9"
                  fill="#f4c49e" rx="2.5"/>
            <ellipse cx="310" cy="50" rx="14" ry="14"
                     fill="#f4c49e"/>
            <ellipse cx="310" cy="38" rx="14" ry="7"
                     fill="#2c1810"/>
            <rect x="296" y="36" width="28" height="9"
                  fill="#2c1810" rx="3.5"/>
            <circle cx="305" cy="48" r="2.2" fill="white"/>
            <circle cx="315" cy="48" r="2.2" fill="white"/>
            <circle cx="305.8" cy="48.5" r="1.1" fill="#2c1810"/>
            <circle cx="315.8" cy="48.5" r="1.1" fill="#2c1810"/>
            <path d="M306 54 Q310 58 314 54"
                  stroke="#c0825a" stroke-width="1.1"
                  fill="none" stroke-linecap="round"/>
        </g>

        <!-- Pin B -->
        <g class="pin-b" style="transform-origin:355px 65px">
            <circle cx="355" cy="65" r="7"
                    fill="rgba(55,138,221,.15)"
                    stroke="rgba(55,138,221,.3)"
                    stroke-width="1"/>
            <circle cx="355" cy="65" r="3" fill="#378ADD"/>
        </g>
        <line x1="270" y1="75" x2="355" y2="65"
              stroke="rgba(192,32,22,.2)"
              stroke-width="1" stroke-dasharray="4 3"/>

        <!-- Bld 4 center -->
        <g class="bld bld4">
            <rect x="420" y="45" width="32" height="48"
                  fill="#162440" rx="2"/>
            <rect x="424" y="50" width="6" height="8"
                  fill="rgba(255,220,100,.5)" rx="1"/>
            <rect x="434" y="50" width="6" height="8"
                  fill="rgba(255,220,100,.3)" rx="1"/>
            <rect x="424" y="63" width="6" height="8"
                  fill="rgba(255,220,100,.6)" rx="1"/>
            <rect x="434" y="63" width="6" height="8"
                  fill="rgba(255,220,100,.4)" rx="1"/>
            <rect x="424" y="76" width="6" height="8"
                  fill="rgba(255,220,100,.3)" rx="1"/>
        </g>

        <!-- Bld 5 center tall -->
        <g class="bld bld5">
            <rect x="465" y="22" width="44" height="71"
                  fill="#1a2d55" rx="2"/>
            <rect x="469" y="28" width="7" height="9"
                  fill="rgba(255,220,100,.7)" rx="1"/>
            <rect x="480" y="28" width="7" height="9"
                  fill="rgba(255,220,100,.4)" rx="1"/>
            <rect x="491" y="28" width="7" height="9"
                  fill="rgba(255,220,100,.6)" rx="1"/>
            <rect x="469" y="43" width="7" height="9"
                  fill="rgba(255,220,100,.5)" rx="1"/>
            <rect x="480" y="43" width="7" height="9"
                  fill="rgba(255,220,100,.3)" rx="1"/>
            <rect x="491" y="43" width="7" height="9"
                  fill="rgba(255,220,100,.7)" rx="1"/>
            <rect x="469" y="58" width="7" height="9"
                  fill="rgba(255,220,100,.4)" rx="1"/>
            <rect x="491" y="58" width="7" height="9"
                  fill="rgba(255,220,100,.5)" rx="1"/>
            <rect x="469" y="73" width="7" height="9"
                  fill="rgba(255,220,100,.3)" rx="1"/>
            <rect x="480" y="73" width="7" height="9"
                  fill="rgba(255,220,100,.6)" rx="1"/>
            <line x1="487" y1="22" x2="487" y2="12"
                  stroke="#C02016" stroke-width="1.5"/>
            <circle cx="487" cy="11" r="2.5" fill="#C02016"/>
        </g>

        <!-- Bld 6 -->
        <g class="bld bld6">
            <rect x="522" y="52" width="28" height="41"
                  fill="#1e2e50" rx="2"/>
            <rect x="526" y="57" width="5" height="7"
                  fill="rgba(255,220,100,.4)" rx="1"/>
            <rect x="535" y="57" width="5" height="7"
                  fill="rgba(255,220,100,.6)" rx="1"/>
            <rect x="526" y="69" width="5" height="7"
                  fill="rgba(255,220,100,.5)" rx="1"/>
            <rect x="535" y="69" width="5" height="7"
                  fill="rgba(255,220,100,.3)" rx="1"/>
        </g>

        <!-- Pin C -->
        <g class="pin-c" style="transform-origin:580px 60px">
            <circle cx="580" cy="60" r="7"
                    fill="rgba(29,158,117,.15)"
                    stroke="rgba(29,158,117,.3)"
                    stroke-width="1"/>
            <circle cx="580" cy="60" r="3" fill="#1D9E75"/>
        </g>
        <line x1="355" y1="65" x2="580" y2="60"
              stroke="rgba(55,138,221,.2)"
              stroke-width="1" stroke-dasharray="4 3"/>

        <!-- Bld 7 right -->
        <g class="bld bld7">
            <rect x="680" y="35" width="38" height="58"
                  fill="#1a2d55" rx="2"/>
            <rect x="684" y="40" width="6" height="8"
                  fill="rgba(255,220,100,.6)" rx="1"/>
            <rect x="694" y="40" width="6" height="8"
                  fill="rgba(255,220,100,.3)" rx="1"/>
            <rect x="704" y="40" width="6" height="8"
                  fill="rgba(255,220,100,.5)" rx="1"/>
            <rect x="684" y="53" width="6" height="8"
                  fill="rgba(255,220,100,.4)" rx="1"/>
            <rect x="694" y="53" width="6" height="8"
                  fill="rgba(255,220,100,.6)" rx="1"/>
            <rect x="704" y="53" width="6" height="8"
                  fill="rgba(255,220,100,.3)" rx="1"/>
            <rect x="684" y="66" width="6" height="8"
                  fill="rgba(255,220,100,.5)" rx="1"/>
            <rect x="704" y="66" width="6" height="8"
                  fill="rgba(255,220,100,.4)" rx="1"/>
        </g>

        <!-- Bld 8 -->
        <g class="bld bld8">
            <rect x="730" y="55" width="26" height="38"
                  fill="#152038" rx="2"/>
            <rect x="734" y="60" width="5" height="7"
                  fill="rgba(255,220,100,.5)" rx="1"/>
            <rect x="743" y="60" width="5" height="7"
                  fill="rgba(255,220,100,.3)" rx="1"/>
            <rect x="734" y="72" width="5" height="7"
                  fill="rgba(255,220,100,.6)" rx="1"/>
            <rect x="743" y="72" width="5" height="7"
                  fill="rgba(255,220,100,.4)" rx="1"/>
        </g>

        <!-- Right side buildings -->
        <g class="bld bld1">
            <rect x="900" y="42" width="36" height="51"
                  fill="#162440" rx="2"/>
            <rect x="904" y="47" width="6" height="8"
                  fill="rgba(255,220,100,.5)" rx="1"/>
            <rect x="914" y="47" width="6" height="8"
                  fill="rgba(255,220,100,.3)" rx="1"/>
            <rect x="924" y="47" width="6" height="8"
                  fill="rgba(255,220,100,.6)" rx="1"/>
            <rect x="904" y="60" width="6" height="8"
                  fill="rgba(255,220,100,.4)" rx="1"/>
            <rect x="924" y="60" width="6" height="8"
                  fill="rgba(255,220,100,.5)" rx="1"/>
            <rect x="904" y="73" width="6" height="8"
                  fill="rgba(255,220,100,.3)" rx="1"/>
            <rect x="914" y="73" width="6" height="8"
                  fill="rgba(255,220,100,.6)" rx="1"/>
        </g>
        <g class="bld bld2">
            <rect x="950" y="20" width="42" height="73"
                  fill="#1a2d55" rx="2"/>
            <rect x="954" y="26" width="7" height="9"
                  fill="rgba(255,220,100,.6)" rx="1"/>
            <rect x="965" y="26" width="7" height="9"
                  fill="rgba(255,220,100,.3)" rx="1"/>
            <rect x="976" y="26" width="7" height="9"
                  fill="rgba(255,220,100,.5)" rx="1"/>
            <rect x="954" y="41" width="7" height="9"
                  fill="rgba(255,220,100,.4)" rx="1"/>
            <rect x="965" y="41" width="7" height="9"
                  fill="rgba(255,220,100,.6)" rx="1"/>
            <rect x="976" y="41" width="7" height="9"
                  fill="rgba(255,220,100,.3)" rx="1"/>
            <rect x="954" y="56" width="7" height="9"
                  fill="rgba(255,220,100,.5)" rx="1"/>
            <rect x="976" y="56" width="7" height="9"
                  fill="rgba(255,220,100,.4)" rx="1"/>
            <rect x="954" y="71" width="7" height="9"
                  fill="rgba(255,220,100,.3)" rx="1"/>
            <rect x="965" y="71" width="7" height="9"
                  fill="rgba(255,220,100,.6)" rx="1"/>
            <line x1="971" y1="20" x2="971" y2="10"
                  stroke="#C02016" stroke-width="1.5"/>
            <circle cx="971" cy="9" r="2.5" fill="#C02016"/>
            <circle cx="971" cy="9" r="8" fill="none"
                    stroke="rgba(192,32,22,.3)"
                    stroke-width="1">
                <animate attributeName="r"
                         values="4;14;4"
                         dur="2s" repeatCount="indefinite"/>
                <animate attributeName="opacity"
                         values="0.5;0;0.5"
                         dur="2s" repeatCount="indefinite"/>
            </circle>
        </g>
        <g class="bld bld3">
            <rect x="1004" y="55" width="26" height="38"
                  fill="#1e2e50" rx="2"/>
            <rect x="1008" y="60" width="5" height="7"
                  fill="rgba(255,220,100,.4)" rx="1"/>
            <rect x="1017" y="60" width="5" height="7"
                  fill="rgba(255,220,100,.6)" rx="1"/>
            <rect x="1008" y="72" width="5" height="7"
                  fill="rgba(255,220,100,.5)" rx="1"/>
            <rect x="1017" y="72" width="5" height="7"
                  fill="rgba(255,220,100,.3)" rx="1"/>
        </g>
        <g class="bld bld4">
            <rect x="1060" y="48" width="30" height="45"
                  fill="#152038" rx="2"/>
            <rect x="1064" y="53" width="6" height="8"
                  fill="rgba(255,220,100,.5)" rx="1"/>
            <rect x="1074" y="53" width="6" height="8"
                  fill="rgba(255,220,100,.3)" rx="1"/>
            <rect x="1064" y="66" width="6" height="8"
                  fill="rgba(255,220,100,.6)" rx="1"/>
            <rect x="1074" y="66" width="6" height="8"
                  fill="rgba(255,220,100,.4)" rx="1"/>
            <rect x="1064" y="79" width="6" height="8"
                  fill="rgba(255,220,100,.3)" rx="1"/>
        </g>
        <g class="bld bld5">
            <rect x="1105" y="60" width="22" height="33"
                  fill="#1a2640" rx="2"/>
            <rect x="1109" y="65" width="5" height="7"
                  fill="rgba(255,220,100,.4)" rx="1"/>
            <rect x="1118" y="65" width="5" height="7"
                  fill="rgba(255,220,100,.6)" rx="1"/>
            <rect x="1109" y="77" width="5" height="7"
                  fill="rgba(255,220,100,.3)" rx="1"/>
        </g>
        <g class="bld bld6">
            <rect x="1140" y="38" width="52" height="55"
                  fill="#162440" rx="2"/>
            <rect x="1144" y="43" width="6" height="8"
                  fill="rgba(255,220,100,.6)" rx="1"/>
            <rect x="1154" y="43" width="6" height="8"
                  fill="rgba(255,220,100,.3)" rx="1"/>
            <rect x="1164" y="43" width="6" height="8"
                  fill="rgba(255,220,100,.5)" rx="1"/>
            <rect x="1144" y="56" width="6" height="8"
                  fill="rgba(255,220,100,.4)" rx="1"/>
            <rect x="1154" y="56" width="6" height="8"
                  fill="rgba(255,220,100,.6)" rx="1"/>
            <rect x="1164" y="56" width="6" height="8"
                  fill="rgba(255,220,100,.3)" rx="1"/>
            <rect x="1144" y="69" width="6" height="8"
                  fill="rgba(255,220,100,.5)" rx="1"/>
            <rect x="1164" y="69" width="6" height="8"
                  fill="rgba(255,220,100,.4)" rx="1"/>
        </g>

    </svg>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
