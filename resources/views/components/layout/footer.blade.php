<!-- <footer class="main-footer-container">
    <div class="container footer-section">
        <div class="footer-item">
            <div class="footer-item-header">
                <a href="{{route('site.index')}}">
                    <x-curator-glider :media="$logo" class="mw-100 mb-5" />
                </a>
            </div>
            <div>
                {!! $footer_description !!}
            </div>
        </div>
        @foreach($menu->links as $index => $child)
            @continue(!$child->status || !$child->has_children())
            <div class="footer-item">
                <div class="footer-item-header">
                    <h5>{{$child->title}}</h5>
                    <button
                            class="toggleButton mobile-responsive"
                            data-target="footer-link-{{$index}}"
                    >
                        <i class="fa-solid fa-plus"></i>
                        <i class="fa-solid fa-minus" style="display: none"></i>
                    </button>
                </div>
                <ul id="footer-link-{{$index}}">
                    @foreach($child->children as $grandson)
                        <li>
                            <a href="{{$grandson->link}}">{{$grandson->title}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach

    <div class="footer-copyright-container">
        <div class="footer-copyright-container-centered">
            <p class="d-flex flex-column align-items-center">@lang('site.copyright', ['year' => \Illuminate\Support\Carbon::now()->year, 'url' => '<a href="https://shiftcodes.net">ShiftCodes</a>'])</p>
            <div class="social-media-icons">
                @if ($twitter)
                    <a href="{{$twitter}}" target="_blank" rel="noopener noreferrer">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                @endif
                @if ($linkedin)
                    <a href="{{$linkedin}}" target="_blank" rel="noopener noreferrer">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                @endif
                @if ($instagram)
                    <a href="{{$instagram}}" target="_blank" rel="noopener noreferrer">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                @endif
                @if ($youtube)
                    <a href="{{$youtube}}" target="_blank" rel="noopener noreferrer">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                @endif
                @if ($facebook)
                    <a href="{{$facebook}}" target="_blank" rel="noopener noreferrer">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
</footer> -->

<footer class="main-footer-container">
      <div class="container footer-section">
        <div class="footer-item">
          <div class="footer-item-header">
            <a href="./index.html">
              <img class="mw-100 mb-5" src="./assets/imgs/home/logo-dark.png" alt="" />
            </a>
          </div>
          <p>
            هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد
            هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو
            العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها
            التطبيق
          </p>
          <div class="home-6th-section p-0">
            <div class="d-flex align-items-start  flex-column h-100 py-4">
              <div>
                <h5>اشترك في أخبارنا</h5>
                <p>
                  هل سئمت من فقدان تحديثاتنا؟ اشترك في أخبارنا الآن وابق على
                  اطلاع!
                </p>
              </div>
              <div class="d-flex justify-content-between gap-2">
                <input type="text" placeholder="البريد الاكتروني">
                <button class="border-0">تأكيد</button>
              </div>
            </div>
          </div>
        </div>
        <div class="footer-item">
          <div class="footer-item-header">
            <h5>روابط مهمة</h5>
            <button class="toggleButton mobile-responsive" data-target="about">
              <i class="fa-solid fa-plus"></i>
              <i class="fa-solid fa-minus" style="display: none"></i>
            </button>
          </div>
          <ul id="about">
            <li>
              <a href=""> الشروط والأحكام</a>
            </li>
            <li><a href=""> سياسة الخصوصية </a></li>
            <li><a href=""> FAQs </a></li>
            <li><a href=""> مركز الدعم</a></li>
          </ul>
        </div>
        <div class="footer-item">
          <div class="footer-item-header">
            <h5>روابط سريعة</h5>
            <button class="toggleButton mobile-responsive" data-target="about">
              <i class="fa-solid fa-plus"></i>
              <i class="fa-solid fa-minus" style="display: none"></i>
            </button>
          </div>
          <ul id="about">
            <li>
              <a href=""> معلومات عنا</a>
            </li>
            <li><a href="">خدماتنا </a></li>
            <li><a href=""> المؤشر </a></li>
            <li>
              <a href="./register-ar.html"> شركات تداول</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="footer-copyright-container">
        <div class="footer-copyright-container-centered">
          <p>طرق الدفع</p>
          <div class="social-media-icons">
            <a href="#">
              <i class="fa-brands fa-paypal"></i>
            </a>
            <a href="#">
              <i class="fa-brands fa-bitcoin"></i>
            </a>

          </div>
        </div>
        <div class="footer-copyright-container-centered">
          <p>حقوق الطبع والنشر © لدى شركة ShiftCodes</p>
          <div class="social-media-icons">
            <a href="#">
              <i class="fa-brands fa-twitter"></i>
            </a>
            <a href="#">
              <i class="fa-brands fa-linkedin-in"></i>
            </a>
            <a href="#">
              <i class="fa-brands fa-instagram"></i>
            </a>
            <a href="#">
              <i class="fa-brands fa-youtube"></i>
            </a>
            <a href="#">
              <i class="fa-brands fa-facebook-f"></i>
            </a>
          </div>
        </div>
      </div>
    </footer>