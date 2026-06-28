{{-- Password Strength Indicator Component --}}
{{-- Usage: @include('components.password-strength', ['inputId' => 'password']) --}}

<div id="{{ $inputId }}_strength_container" style="margin-top: 0.5rem; display: none;">
    {{-- Strength Bar --}}
    <div style="display: flex; gap: 4px; margin-bottom: 0.35rem;">
        <div id="{{ $inputId }}_bar1" style="height: 4px; flex: 1; border-radius: 99px; background: #e2e8f0; transition: background 0.3s;"></div>
        <div id="{{ $inputId }}_bar2" style="height: 4px; flex: 1; border-radius: 99px; background: #e2e8f0; transition: background 0.3s;"></div>
        <div id="{{ $inputId }}_bar3" style="height: 4px; flex: 1; border-radius: 99px; background: #e2e8f0; transition: background 0.3s;"></div>
        <div id="{{ $inputId }}_bar4" style="height: 4px; flex: 1; border-radius: 99px; background: #e2e8f0; transition: background 0.3s;"></div>
        <div id="{{ $inputId }}_bar5" style="height: 4px; flex: 1; border-radius: 99px; background: #e2e8f0; transition: background 0.3s;"></div>
    </div>
    
    {{-- Strength Label --}}
    <div id="{{ $inputId }}_strength_label" style="font-size: 0.75rem; font-weight: 600; margin-bottom: 0.5rem; transition: color 0.3s;"></div>
    
    {{-- Checklist --}}
    <div style="display: flex; flex-wrap: wrap; gap: 0.35rem 1rem;">
        <div id="{{ $inputId }}_check_length" style="font-size: 0.75rem; color: #94a3b8; display: flex; align-items: center; gap: 0.3rem; transition: color 0.3s;">
            <svg id="{{ $inputId }}_icon_length" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
            Min. 8 karakter
        </div>
        <div id="{{ $inputId }}_check_upper" style="font-size: 0.75rem; color: #94a3b8; display: flex; align-items: center; gap: 0.3rem; transition: color 0.3s;">
            <svg id="{{ $inputId }}_icon_upper" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
            Huruf kapital (A-Z)
        </div>
        <div id="{{ $inputId }}_check_lower" style="font-size: 0.75rem; color: #94a3b8; display: flex; align-items: center; gap: 0.3rem; transition: color 0.3s;">
            <svg id="{{ $inputId }}_icon_lower" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
            Huruf kecil (a-z)
        </div>
        <div id="{{ $inputId }}_check_number" style="font-size: 0.75rem; color: #94a3b8; display: flex; align-items: center; gap: 0.3rem; transition: color 0.3s;">
            <svg id="{{ $inputId }}_icon_number" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
            Angka (0-9)
        </div>
        <div id="{{ $inputId }}_check_special" style="font-size: 0.75rem; color: #94a3b8; display: flex; align-items: center; gap: 0.3rem; transition: color 0.3s;">
            <svg id="{{ $inputId }}_icon_special" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
            Karakter spesial (!@#$%)
        </div>
    </div>
</div>

<script>
(function() {
    const inputId = '{{ $inputId }}';
    const input = document.getElementById(inputId);
    if (!input) return;

    const container = document.getElementById(inputId + '_strength_container');
    const label = document.getElementById(inputId + '_strength_label');
    const bars = [
        document.getElementById(inputId + '_bar1'),
        document.getElementById(inputId + '_bar2'),
        document.getElementById(inputId + '_bar3'),
        document.getElementById(inputId + '_bar4'),
        document.getElementById(inputId + '_bar5'),
    ];

    const checks = {
        length:  document.getElementById(inputId + '_check_length'),
        upper:   document.getElementById(inputId + '_check_upper'),
        lower:   document.getElementById(inputId + '_check_lower'),
        number:  document.getElementById(inputId + '_check_number'),
        special: document.getElementById(inputId + '_check_special'),
    };

    const icons = {
        length:  document.getElementById(inputId + '_icon_length'),
        upper:   document.getElementById(inputId + '_icon_upper'),
        lower:   document.getElementById(inputId + '_icon_lower'),
        number:  document.getElementById(inputId + '_icon_number'),
        special: document.getElementById(inputId + '_icon_special'),
    };

    const checkSvg = `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>`;
    const uncheckSvg = `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="8" y1="12" x2="16" y2="12"/></svg>`;

    const strengthLevels = [
        { label: 'Sangat Lemah', color: '#ef4444' },
        { label: 'Lemah', color: '#f97316' },
        { label: 'Cukup', color: '#eab308' },
        { label: 'Kuat', color: '#22c55e' },
        { label: 'Sangat Kuat', color: '#16a34a' },
    ];

    function updateCheck(key, passed) {
        if (passed) {
            checks[key].style.color = '#16a34a';
            icons[key].outerHTML = checkSvg.replace('id="', 'id="' + inputId + '_icon_' + key + '" ');
            // Re-query the icon after replacing outerHTML
            icons[key] = document.getElementById(inputId + '_icon_' + key) || checks[key].querySelector('svg');
        } else {
            checks[key].style.color = '#94a3b8';
            icons[key].outerHTML = uncheckSvg.replace('id="', 'id="' + inputId + '_icon_' + key + '" ');
            icons[key] = document.getElementById(inputId + '_icon_' + key) || checks[key].querySelector('svg');
        }
    }

    input.addEventListener('input', function() {
        const val = this.value;
        
        if (val.length === 0) {
            container.style.display = 'none';
            return;
        }
        
        container.style.display = 'block';

        const hasLength = val.length >= 8;
        const hasUpper = /[A-Z]/.test(val);
        const hasLower = /[a-z]/.test(val);
        const hasNumber = /[0-9]/.test(val);
        const hasSpecial = /[!@#$%^&*()_+\-=\[\]{}|;:'",.<>?\/`~\\]/.test(val);

        updateCheck('length', hasLength);
        updateCheck('upper', hasUpper);
        updateCheck('lower', hasLower);
        updateCheck('number', hasNumber);
        updateCheck('special', hasSpecial);

        const score = [hasLength, hasUpper, hasLower, hasNumber, hasSpecial].filter(Boolean).length;

        // Update bars
        bars.forEach((bar, i) => {
            if (i < score) {
                bar.style.background = strengthLevels[score - 1].color;
            } else {
                bar.style.background = '#e2e8f0';
            }
        });

        // Update label
        if (score > 0) {
            label.textContent = strengthLevels[score - 1].label;
            label.style.color = strengthLevels[score - 1].color;
        } else {
            label.textContent = '';
        }
    });
})();
</script>
