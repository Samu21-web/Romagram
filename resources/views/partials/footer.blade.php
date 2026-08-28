<footer style="background:#6A0996; color:#9ca3af; padding:48px 24px 28px;">
    <div style="max-width:1200px; margin:0 auto;">

        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12" style="margin-bottom:32px;">

            <!-- Brand -->
            <div>
                <img src="{{ asset('logo.png') }}" alt="Romagram" style="height:44px; display:block; margin-bottom:12px;">
                <p style="line-height:1.7; font-size:14px; margin:0 0 20px; max-width:280px;">
                    Find love at your own pace. Connecting real people worldwide for genuine relationships.
                </p>
                <!-- Social on mobile shows here -->
                <div class="flex gap-3 md:hidden">
                    <a href="#" style="width:36px; height:36px; background:#1f2937; border-radius:8px; display:flex; align-items:center; justify-content:center; color:#9ca3af; text-decoration:none;">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#" style="width:36px; height:36px; background:#1f2937; border-radius:8px; display:flex; align-items:center; justify-content:center; color:#9ca3af; text-decoration:none;">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                    <a href="#" style="width:36px; height:36px; background:#1f2937; border-radius:8px; display:flex; align-items:center; justify-content:center; color:#9ca3af; text-decoration:none;">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                    <a href="#" style="width:36px; height:36px; background:#1f2937; border-radius:8px; display:flex; align-items:center; justify-content:center; color:#9ca3af; text-decoration:none;">
                        <i class="fa-brands fa-tiktok"></i>
                    </a>
                </div>
            </div>

            <!-- Legal -->
            <div>
                <p style="color:white; font-weight:700; font-size:14px; margin-bottom:14px; text-transform:uppercase; letter-spacing:0.5px;">Legal</p>
                <ul style="list-style:none; padding:0; margin:0;">
                    <li style="margin-bottom:10px;">
                        <a href="{{ route('page.privacy') }}"
                           style="color:#e9d5ff; text-decoration:none; font-size:14px; display:flex; align-items:center; gap:8px;"
                           onmouseover="this.style.color='white'" onmouseout="this.style.color='#e9d5ff'">
                            <i class="fa-solid fa-circle-dot" style="font-size:8px; color:#c084fc;"></i> Privacy Policy
                        </a>
                    </li>
                    <li style="margin-bottom:10px;">
                        <a href="{{ route('page.terms') }}"
                           style="color:#e9d5ff; text-decoration:none; font-size:14px; display:flex; align-items:center; gap:8px;"
                           onmouseover="this.style.color='white'" onmouseout="this.style.color='#e9d5ff'">
                            <i class="fa-solid fa-circle-dot" style="font-size:8px; color:#c084fc;"></i> Terms of Service
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Social (desktop only) -->
            <div class="hidden md:block">
                <p style="color:white; font-weight:700; font-size:14px; margin-bottom:14px; text-transform:uppercase; letter-spacing:0.5px;">Follow Us</p>
                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                    <a href="#" style="width:38px; height:38px; background:rgba(255,255,255,0.1); border-radius:10px; display:flex; align-items:center; justify-content:center; color:white; text-decoration:none; transition:all 0.2s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#" style="width:38px; height:38px; background:rgba(255,255,255,0.1); border-radius:10px; display:flex; align-items:center; justify-content:center; color:white; text-decoration:none; transition:all 0.2s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                    <a href="#" style="width:38px; height:38px; background:rgba(255,255,255,0.1); border-radius:10px; display:flex; align-items:center; justify-content:center; color:white; text-decoration:none; transition:all 0.2s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                    <a href="#" style="width:38px; height:38px; background:rgba(255,255,255,0.1); border-radius:10px; display:flex; align-items:center; justify-content:center; color:white; text-decoration:none; transition:all 0.2s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                        <i class="fa-brands fa-tiktok"></i>
                    </a>
                </div>
            </div>

        </div>

        <!-- Bottom bar -->
        <div style="border-top:1px solid rgba(255,255,255,0.15); padding-top:20px;">
            <div class="flex flex-col md:flex-row items-center justify-between gap-2 text-center md:text-left">
                <p style="font-size:12px; margin:0; color:#c4b5fd;">© {{ date('Y') }} Romagram. All rights reserved.</p>
                <p style="font-size:12px; margin:0; color:#c4b5fd;">Made with <i class="fa-solid fa-heart" style="color:#EC4899;"></i> for love seekers worldwide</p>
            </div>
        </div>

    </div>
</footer>