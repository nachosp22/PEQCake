<!-- Member Modal with Pacman Levels -->
<div id="member-modal-overlay" 
     class="app-modal-overlay"
     style="display:none; background:rgba(0,0,0,0.85); z-index:1000; backdrop-filter:blur(4px);"
     onclick="if(event.target===this)closeMemberModal()">
    <div id="member-modal" 
          class="app-modal-dialog app-modal-scroll"
          style="background:var(--surface,#121212); border:2px solid rgba(242,183,5,0.4); --app-modal-radius:24px; box-shadow:0 24px 60px rgba(0,0,0,0.7), 0 0 40px rgba(242,183,5,0.1);">
        
        <!-- Header -->
        <div style="padding:1.5rem 2rem 1rem; text-align:center; background:linear-gradient(180deg, rgba(242,183,5,0.12) 0%, transparent 100%); border-radius:22px 22px 0 0;">
            <div style="font-family:'Bebas Neue',sans-serif; color:var(--yellow,#f2b705); font-size:1.8rem; letter-spacing:0.1em;">
                TARJETA PEQLOVER
            </div>
            <div style="font-family:'Bebas Neue',sans-serif; color:var(--cream,#f7eed9); font-size:3.5rem; letter-spacing:0.08em; line-height:1; margin-top:0.2rem;">
                {{ $member->formattedMemberNumber }}
            </div>
            @if($member->name)
                <div style="color:var(--text,#f4f4f4); font-weight:700; font-size:1.15rem; margin-top:0.3rem;">{{ $member->name }}</div>
            @endif
        </div>

        @if($member->total_orders > 0)
        <!-- Stats row (solo si tiene pedidos) -->
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; padding:1rem 2rem;">
            <div style="background:rgba(242,183,5,0.08); border:1px solid rgba(242,183,5,0.2); border-radius:14px; padding:1rem; text-align:center;">
                <div style="color:var(--muted,#9a9a9a); font-size:0.7rem; font-weight:800; text-transform:uppercase; letter-spacing:0.15em; margin-bottom:0.4rem;">🍰 Pedidos</div>
                <div style="font-family:'Bebas Neue',sans-serif; color:var(--yellow,#f2b705); font-size:2.2rem;">{{ $member->total_orders }}</div>
            </div>
            <div style="background:rgba(242,183,5,0.08); border:1px solid rgba(242,183,5,0.2); border-radius:14px; padding:1rem; text-align:center;">
                <div style="color:var(--muted,#9a9a9a); font-size:0.7rem; font-weight:800; text-transform:uppercase; letter-spacing:0.15em; margin-bottom:0.4rem;">⭐ nivel</div>
                <div style="font-family:'Bebas Neue',sans-serif; color:var(--yellow,#f2b705); font-size:2.2rem;">{{ $member->current_level }}</div>
            </div>
        </div>

        <!-- Pacman S path - 10 niveles (1-10) -->
        <div style="padding:0.5rem 2rem 1rem;">
            <div style="color:var(--muted,#9a9a9a); font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:0.12em; text-align:center; margin-bottom:1rem;">
                Nivel de premios 🏆
            </div>
            
            <!-- Top row: niveles 1-5 -->
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.8rem;">
                @for($i = 1; $i <= 5; $i++)
                    <?php
                        $isCompleted = $member->current_level > $i;
                        $isCurrent = $i === $member->current_level;
                        $isPrize = $i === 3 || $i === 5;
                    ?>
                    <div style="position:relative; width:48px; height:48px; display:flex; align-items:center; justify-content:center;">
                        {{-- Gift SVG detrás --}}
                        @if($isPrize)
                            <svg viewBox="0 0 24 24" style="position:absolute; width:50px; height:50px; opacity:0.45; filter:blur(1px);" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="3" y="8" width="18" height="13" rx="2" fill="#f2b705"/>
                                <rect x="3" y="8" width="18" height="4" fill="#c8872a"/>
                                <rect x="10" y="8" width="4" height="13" fill="#c8872a"/>
                                <path d="M12 3C12 3 8 6 8 8.5C8 9.328 8.672 10 9.5 10C10.328 10 11 9.328 11 8.5C11 7.672 11.5 6.5 12 5.5C12.5 6.5 13 7.672 13 8.5C13 9.328 13.672 10 14.5 10C15.328 10 16 9.328 16 8.5C16 6 12 3 12 3Z" fill="#f2b705"/>
                            </svg>
                        @endif
                        
                        @if($isCurrent)
                            <div style="
                                width:48px; height:48px;
                                border-radius:12px;
                                background:linear-gradient(135deg, var(--yellow-2,#f9cc45), var(--yellow,#f2b705));
                                box-shadow:0 0 20px rgba(242,183,5,1);
                                display:flex; align-items:center; justify-content:center;
                                animation:pulse-glow 1s ease-in-out infinite;
                                position:relative; z-index:1;
                            ">
                                <img src="{{ asset('img/pacman.svg') }}" alt="Nivel en progreso" style="width:42px; height:42px; object-fit:contain;">
                            </div>
                        @elseif($isCompleted)
                            <div style="
                                width:48px; height:48px; 
                                border-radius:12px; 
                                background:var(--yellow,#f2b705); 
                                box-shadow:0 0 16px rgba(242,183,5,0.8);
                                display:flex; align-items:center; justify-content:center;
                                position:relative; z-index:1;
                            ">
                                <svg viewBox="0 0 24 24" role="img" aria-label="Nivel completado" style="width:41px; height:41px;">
                                    <path d="M5 13L10 18L19 7" fill="none" stroke="#1d1d1d" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        @else
                            <div style="
                                width:48px; height:48px; 
                                border-radius:12px; 
                                background:rgba(255,255,255,0.04); 
                                border:2px solid rgba(255,255,255,0.12);
                                display:flex; align-items:center; justify-content:center;
                                position:relative; z-index:1;
                            ">
                                <span style="font-family:'Bebas Neue',sans-serif; font-size:1.2rem; color:rgba(255,255,255,0.4);">{{ $i }}</span>
                            </div>
                        @endif
                    </div>
                @endfor
            </div>
            
            <!-- Bottom row: niveles 6-10 -->
            <div style="display:flex; justify-content:space-between; align-items:center;">
                @for($i = 6; $i <= 10; $i++)
                    <?php
                        $isCompleted = $member->current_level > $i;
                        $isCurrent = $i === $member->current_level;
                        $isPrize = $i === 10;
                    ?>
                    <div style="position:relative; width:48px; height:48px; display:flex; align-items:center; justify-content:center;">
                        {{-- Trofeo para nivel 10 --}}
                        @if($isPrize)
                            <svg viewBox="0 0 24 24" style="position:absolute; width:50px; height:50px; opacity:0.45; filter:blur(1px);" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="#f2b705" stroke="#c8872a" stroke-width="1"/>
                            </svg>
                        @endif
                        
                        @if($isCurrent)
                            <div style="
                                width:48px; height:48px; 
                                border-radius:12px; 
                                background:linear-gradient(135deg, var(--yellow-2,#f9cc45), var(--yellow,#f2b705)); 
                                box-shadow:0 0 20px rgba(242,183,5,1);
                                display:flex; align-items:center; justify-content:center;
                                animation:pulse-glow 1s ease-in-out infinite;
                                position:relative; z-index:1;
                            ">
                                <img src="{{ asset('img/pacman.svg') }}" alt="Nivel en progreso" style="width:42px; height:42px; object-fit:contain;">
                            </div>
                        @elseif($isCompleted)
                            <div style="
                                width:48px; height:48px; 
                                border-radius:12px; 
                                background:var(--yellow,#f2b705); 
                                box-shadow:0 0 16px rgba(242,183,5,0.8);
                                display:flex; align-items:center; justify-content:center;
                                position:relative; z-index:1;
                            ">
                                <svg viewBox="0 0 24 24" role="img" aria-label="Nivel completado" style="width:41px; height:41px;">
                                    <path d="M5 13L10 18L19 7" fill="none" stroke="#1d1d1d" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        @else
                            <div style="
                                width:48px; height:48px; 
                                border-radius:12px; 
                                background:rgba(255,255,255,0.04); 
                                border:2px solid rgba(255,255,255,0.12);
                                display:flex; align-items:center; justify-content:center;
                                position:relative; z-index:1;
                            ">
                                <span style="font-family:'Bebas Neue',sans-serif; font-size:1.2rem; color:rgba(255,255,255,0.4);">{{ $i }}</span>
                            </div>
                        @endif
                    </div>
                @endfor
            </div>
            
            <!-- Level info -->
            <div style="text-align:center; margin-top:1.25rem;">
                @if($member->current_level === 10)
                    <span style="color:var(--yellow,#f2b705); font-weight:700; font-size:1rem;">
                        ¡Premio de 10 pedidos! 🏆<br>
                        <span style="color:var(--cream,#f7eed9); font-size:0.85rem;">Nivel máximo conseguido</span>
                    </span>
                @elseif($member->current_level >= 3)
                    <span style="color:var(--yellow,#f2b705); font-weight:700; font-size:1rem;">
                        ¡Premio en camino! 🎁<br>
                        <span style="color:var(--cream,#f7eed9); font-size:0.85rem;">{{ $member->total_orders }} pedidos</span>
                    </span>
                @else
                    <span style="color:var(--cream,#f7eed9); font-size:0.9rem;">
                @endif
            </div>
        </div>
        @else
        <!-- Sin pedidos aún -->
        <div style="padding:2rem 2rem; text-align:center;">
            <div style="font-size:3rem; margin-bottom:1rem;">🍰</div>
            <p style="color:var(--muted,#9a9a9a); font-size:1rem; margin-bottom:0.5rem;">¡Aún no tienes pedidos!</p>
            <p style="color:var(--cream,#f7eed9); font-size:0.9rem;">Haz tu primera compra para<br>empezar a acumular niveles.</p>
        </div>
        @endif

        <!-- Actions -->
        <div style="padding:0.75rem 2rem 1.5rem; display:grid; gap:0.6rem;">
            <form method="POST" action="{{ route('member.logout') }}">
                @csrf
                <button type="submit" style="
                    width:100%; 
                    min-height:48px; 
                    border-radius:12px; 
                    border:1px solid rgba(255,107,107,0.3); 
                    background:rgba(255,107,107,0.08); 
                    color:#ffd1d1; 
                    font-family:'Manrope',sans-serif; 
                    font-size:0.82rem; 
                    font-weight:700; 
                    letter-spacing:0.07em; 
                    text-transform:uppercase; 
                    cursor:pointer;
                    transition:background 0.2s;
                ">Cerrar sesión</button>
            </form>
            <button onclick="closeMemberModal()" style="
                width:100%; 
                min-height:48px; 
                border-radius:12px; 
                border:1px solid rgba(242,183,5,0.4); 
                background:rgba(242,183,5,0.1); 
                color:var(--yellow,#f2b705); 
                font-family:'Manrope',sans-serif; 
                font-size:0.82rem; 
                font-weight:700; 
                letter-spacing:0.07em; 
                text-transform:uppercase; 
                cursor:pointer;
                transition:background 0.2s;
            ">Cerrar</button>
        </div>
    </div>
</div>

@once
    @include('components.app-modal-sizing-styles')
@endonce

<style>
@keyframes pulse-glow {
    0%, 100% { box-shadow: 0 0 12px rgba(242,183,5,0.7); }
    50% { box-shadow: 0 0 24px rgba(242,183,5,1); }
}
</style>

<script>
function openMemberModal() {
    document.getElementById('member-modal-overlay').style.display = 'grid';
    document.body.style.overflow = 'hidden';
}
function closeMemberModal() {
    document.getElementById('member-modal-overlay').style.display = 'none';
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeMemberModal();
});
</script>
