(function($) {
    'use strict';
    
    let currentSize = 256;
    let currentStyle = 'subtle';
    
    const icons = {
        'vegan': { name: 'Vegan', color: '#2d6a24', text: 'VG', fontSize: 32 },
        'vegetarian': { name: 'Vegetarian', color: '#7eb33d', text: 'V', fontSize: 38 },
        'gluten-free': { name: 'Gluten Free', color: '#1b7ab1', text: 'GF', fontSize: 32 },
        'dairy-free': { name: 'Dairy Free', color: '#19b2dd', text: 'DF', fontSize: 32 },
        'egg-free': { name: 'Egg Free', color: '#f8962b', text: 'EF', fontSize: 32 },
        'halal': { name: 'Halal Friendly', color: '#ffb366', text: 'H', fontSize: 38 }
    };
    
    $(document).ready(function() {
        renderGrid();
        updateDemo();
        
        // Size button clicks
        $(document).on('click', '.dig-size-btn', function() {
            currentSize = $(this).data('size');
            $('.dig-size-btn').removeClass('active');
            $(this).addClass('active');
        });
        
        // Style button clicks
        $(document).on('click', '.dig-style-btn', function() {
            currentStyle = $(this).data('style');
            $('.dig-style-btn').removeClass('active');
            $(this).addClass('active');
            renderGrid();
            updateDemo();
        });
        
        // Download all button
        $('#digDownloadAll').on('click', function() {
            downloadAll();
        });
    });
    
    function renderGrid() {
        const $grid = $('#digIconGrid');
        $grid.empty();
        
        $.each(icons, function(key, data) {
            generateIconSVG(key, data, function(svg) {
                const $card = $('<div class="dig-icon-card"></div>');
                
                const $preview = $('<div class="dig-icon-preview"></div>').html(svg);
                const $name = $('<div class="dig-icon-name"></div>').text(data.name);
                const $btn = $('<button class="dig-download-btn">Download PNG</button>');
                
                $btn.on('click', function() {
                    downloadIcon(key, data, svg);
                });
                
                $card.append($preview).append($name).append($btn);
                $grid.append($card);
            });
        });
    }
    
    function updateDemo() {
        const $demoBadges = $('#digDemoBadges');
        $demoBadges.empty();
        
        const demoTypes = ['vegan', 'gluten-free', 'dairy-free'];
        
        $.each(demoTypes, function(index, key) {
            generateIconSVG(key, icons[key], function(svg) {
                $demoBadges.append(svg);
            });
        });
    }
    
    function generateIconSVG(key, data, callback) {
        $.ajax({
            url: digAdmin.ajax_url,
            type: 'POST',
            data: {
                action: 'dig_generate_icon',
                nonce: digAdmin.nonce,
                icon_type: key,
                style: currentStyle,
                size: currentSize
            },
            success: function(response) {
                if (response.success && response.data.svg) {
                    callback(response.data.svg);
                }
            }
        });
    }
    
    function downloadIcon(key, data, svg) {
        svgToPng(svg, currentSize, function(blob) {
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = key + '-' + currentStyle + '-' + currentSize + 'px.png';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        });
    }
    
    function downloadAll() {
        let delay = 0;
        $.each(icons, function(key, data) {
            setTimeout(function() {
                generateIconSVG(key, data, function(svg) {
                    downloadIcon(key, data, svg);
                });
            }, delay);
            delay += 500;
        });
    }
    
    function svgToPng(svgString, size, callback) {
        const canvas = document.createElement('canvas');
        canvas.width = size;
        canvas.height = size;
        const ctx = canvas.getContext('2d');
        
        const img = new Image();
        const svgBlob = new Blob([svgString], { type: 'image/svg+xml;charset=utf-8' });
        const url = URL.createObjectURL(svgBlob);
        
        img.onload = function() {
            ctx.drawImage(img, 0, 0, size, size);
            URL.revokeObjectURL(url);
            canvas.toBlob(callback, 'image/png');
        };
        
        img.src = url;
    }
    
})(jQuery);
