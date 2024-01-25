var base = $('base').attr('href');

if ($('.yt-player').length) {
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    var videos = [];
    $('.yt-player').each(function(i,v) {
        $(this).attr('id', 'yt-player-' + i);
        videos.push($(this));
    });
    var player = [];
    function onYouTubeIframeAPIReady() {
        var h = 0;
        var w = 0;
        $.each(videos,function(i, val) {
            h = val.data('height');
            w = val.data('width');
            player[i] = new YT.Player(val[0], {
                height: h,
                width: w,
                videoId: val.data('v'),
                events: {
                    'onStateChange': onPlayerStateChange
                },
                playerVars: {
                    'autoplay': 0,
                    'controls': 1,
                    'autohide': 0,
                    'enablejsapi': 1,
                    'wmode': 'opaque',
                    'origin': $('base').attr('href')
                }
            });
        });
    }

    function onPlayerReady(event) {
      event.target.playVideo();
    }
    var done = false;
    function onPlayerStateChange(event) {
      if (event.data == YT.PlayerState.PLAYING && !done) {
        setTimeout(stopVideo, 6000);
        done = true;
      }
    }
    function stopVideo() {
      player.stopVideo();
    }
}


function captchaCallback() {
    //  Initialize Recaptcha
    var captchas = document.querySelectorAll('.recaptcha_el');

    if (captchas.length) {
        captchas.forEach(function(element, index) {
            grecaptcha.render(element, {
                "sitekey": '6LcbFjEUAAAAAJ141oYZru2ccF20qQ6nCdXaF25U',
            });
        });
    }
}

/** Limpa CEP */
function clear_cep(_parent) {
    $(_parent).find(".fill-rua").val('').blur();
    $(_parent).find(".fill-bairro").val('').blur();
    $(_parent).find(".fill-cidade").val('').blur();
    $(_parent).find(".fill-uf").val('').blur();
}

/** Preenche CEP */
function getAddress(cep, _parent) {
    clear_cep(_parent);
    cep = cep.replace(/\D/g, '');
    if (cep != "") {
        var validacep = /^[0-9]{8}$/;
        if (validacep.test(cep)) {
            $.getJSON("//viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {
                if (!("erro" in dados)) {
                    $(_parent).find(".fill-rua").val(dados.logradouro).blur();
                    $(_parent).find(".fill-bairro").val(dados.bairro).blur();
                    $(_parent).find(".fill-cidade").val(dados.localidade).blur();
                    $(_parent).find(".fill-uf").val(dados.uf).blur();
                } else {
                    clear_cep(_parent);
                    swal("Erro!", "CEP não encontrado.", "error");
                }
            });
        } else {
            clear_cep(_parent);
            swal("Erro!", "Formato de CEP inválido.", "error");
        }
    } else {
        clear_cep(_parent);
    }
}

/**
 * Load Google Maps Script
 */
function loadScript() {
    var script = document.createElement("script");
    script.src = "https://maps.googleapis.com/maps/api/js?callback=initialize&key=AIzaSyBiF5p0Xpp1nWnlafPYqKgujtsyfZxVebQ";
    document.body.appendChild(script);
}

/**
 * Initialize Google Maps
 */
function initialize() {
    var el = 'map';
    var _title = $('#map').data('title');
    var lat = $('#map').data('lat');
    var lng = $('#map').data('lng');
    var mapCenter = new google.maps.LatLng(lat, lng);
    var mapProp = {
        center: mapCenter,
        zoom: 13,
        scrollwheel: false,
        panControl: true,
        zoomControl: true,
        mapTypeControl: false,
        scaleControl: true,
        streetViewControl: true,
        overviewMapControl: false,
        rotateControl: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        styles: [
            {
              "featureType": "administrative.land_parcel",
              "stylers": [
                {
                  "visibility": "off"
                }
              ]
            },
            {
              "featureType": "administrative.neighborhood",
              "stylers": [
                {
                  "visibility": "off"
                }
              ]
            },
            {
              "featureType": "poi",
              "elementType": "labels.text",
              "stylers": [
                {
                  "visibility": "off"
                }
              ]
            },
            {
              "featureType": "poi.business",
              "stylers": [
                {
                  "visibility": "off"
                }
              ]
            },
            {
              "featureType": "poi.park",
              "elementType": "labels.text",
              "stylers": [
                {
                  "visibility": "off"
                }
              ]
            },
            {
              "featureType": "road",
              "elementType": "labels",
              "stylers": [
                {
                  "visibility": "off"
                }
              ]
            },
            {
              "featureType": "water",
              "elementType": "labels.text",
              "stylers": [
                {
                  "visibility": "off"
                }
              ]
            }
          ]
        };
    var mapMap = new google.maps.Map(document.getElementById(el), mapProp);

    var infowindow = new google.maps.InfoWindow({
        content: "<span>Audax</span>"
    });


    var mapMarker = new google.maps.Marker({
        position: mapCenter,
        title: 'Audax'
    });
    mapMarker.setMap(mapMap);

    google.maps.event.addListener(mapMarker, 'click', function() {
        infowindow.open(mapMap,mapMarker);
    });
}


$(function() {

    /**
     * jQuery Masks
     */
    var SPMaskBehavior = function(val) {
        return val.replace(/\D/g, "").length === 11 ?
            "(00) 00000-0000" :
            "(00) 0000-00009";
    },
    spOptions = {
        onKeyPress: function(val, e, field, options) {
            field.mask(SPMaskBehavior.apply({}, arguments), options);
        }
    };
    $(".cel-field").mask(SPMaskBehavior, spOptions);
    $('.tel-field').mask('(00) 0000-0000');
    $(".cpf-field").mask('000.000.000-00');
    $(".cnpj-field").mask('00.000.000/0000-00');
    $(".cep-field").mask('00000-000');
    $('.cep-field').blur(function() {
        var cep = $(this).val();
        getAddress(cep, $(this).closest('fieldset'));
    });

    /**
     * Menu Charger
     */
    // function menuChanger() {
    //     var img = $(".navbar-brand");
    //     if ($(window).scrollTop()) {
    //       img.css("width", 55);
    //     } else {
    //       img.css("width", 130);
    //     }
    //     setTimeout(function() {
    //       menuFixer();
    //     }, 600);
    //   }
      
    //   $(window).on("scroll", menuChanger);

    /**
     * Set Sticky Header
     */
    // if ($('.header-sticky').length) {
    //     var sc;
    //     $(window).on('scroll', function() {
    //         sc = $(window).scrollTop();
    //         if (sc > 50) {
    //             $('header').addClass('page-scrolled');
    //         } else {
    //             $('header').removeClass('page-scrolled');
    //         }
    //     });
    // }

    /**
     * Set Home Page Banner
     */
    if ($('.main-banner').length) {
        var mainBanner = $('.main-banner .owl-carousel');
        mainBanner.on('resize.owl.carousel', function() {
            var _ww = $(window).width();
            var _hh = $('header').height();
            if (_ww > 1200) {
                var _wh = $(window).height();
                mainBanner.trigger('refresh.owl.carousel');
                mainBanner.find('.item').css({'padding-bottom':'0', 'height' : (_wh - _hh) + 'px'});
            } else {
                var _wh = $(window).height();
                mainBanner.trigger('refresh.owl.carousel');
                mainBanner.find('.item').css({'padding-bottom' : '50%', 'height' : '0px'});
            }
        });
        mainBanner.on('initialized.owl.carousel', function() {
            var _hh = $('header').height();
            var _wh = $(window).height();
            var _ww = $(window).width();
            if (_ww > 1200) {
                mainBanner.find('.item').height(_wh - _hh).css('padding-bottom', '0');
            } else {
                mainBanner.find('.item').height(0).css('padding-bottom', '50%');
            }
        });
        mainBanner.owlCarousel({
            items: 1,
            loop: true,
            smartSpeed: 1200,
            autoplay: true,
            autoplayTimeout: 7000,
            stopOnHover: false,
            lazyLoad: true,
            dots: true,
            nav: true,
            navText: [
                '<img src=\"' + base + 'images/icons/esquerda.png\">',
                '<img src=\"' + base + 'images/icons/direita.png\">'
            ]
        });


    }

    /**
     * Custom generic carousel
     */
    if ($('.basic-carousel').length) {
        $('.basic-carousel').each(function() {
            var _items = $(this).data('items') ? $(this).data('items') : 1;
            var _itemsTablet = $(this).data('items-tablet') ? $(this).data('items-tablet') : 1;
            var _itemsPhone = $(this).data('items-phone') ? $(this).data('items-phone') : 1;
            var _lazy = $(this).data('lazy') ? $(this).data('lazy') : false;
            var _nav = $(this).data('nav') ? $(this).data('nav') : false;
            var _margin = $(this).data('margin') ? $(this).data('margin') : 0;
            var _dots = $(this).data('dots') ? $(this).data('dots') : false;
            var _loop = $(this).data('loop') ? $(this).data('loop') : false;
            var _speed = $(this).data('speed') ? $(this).data('speed') : 1000;
            var _autoplay = $(this).data('autoplay') ? $(this).data('autoplay') : false;
            var _autoplayTime = $(this).data('autoplay-time') ? $(this).data('autoplay-time') : '5000';
            var _autowidth = $(this).data('autowidth') ? $(this).data('autowidth') : false;
            var _autoheight = $(this).data('autoheight') ? $(this).data('autoheight') : false;
            var _anim_in = $(this).data('anim-in') ? $(this).data('anim-in') : '';
            var _anim_out = $(this).data('anim-out') ? $(this).data('anim-out') : '';
            var _drag = $(this).data('drag') ? $(this).data('drag') : 'true';
            var _stop = $(this).data('stop') ? $(this).data('stop') : 'true';
            $(this).owlCarousel({
                items: _items,
                margin: 15,
                lazyLoad : _lazy,
                dots : _dots,
                margin: _margin,
                smartSpeed : _speed,
                stopOnHover : true,
                autoplay : _autoplay,
                autoplayTimeout : _autoplayTime,
                autoHeight : _autoheight,
                autoWidth : _autowidth,
                nav : _nav,
                navText: [
                    '<img src=\"' + base + 'images/icons/esquerda.png\">',
                    '<img src=\"' + base + 'images/icons/direita.png\">'
                    // '<i class="fa fa-angle-left"></i>',
                    // '<i class="fa fa-angle-right"></i>'
                ],
                animateIn : _anim_in,
                animateOut : _anim_out,
                loop : _loop,
                mouseDrag : _drag,
                touchDrag : _drag,
                pullDrag : _drag,
                freeDrag : _drag,
                responsive: {
                    0: {
                        items: _itemsPhone
                    },
                    769: {
                        items: _itemsTablet
                    },
                    1200: {
                        items: _items
                    }
                }
            });
        });
    }

    /**
     * Responsivo Header Menu Toggler
     */
    if ($('.navbar-toggler').length) {
        $(document).on('click', '.navbar-toggler', function() {
            var altimg = 'images/icons/menu-alt.png';
            var img = 'images/icons/menu.png';
            if ($(this).hasClass('expanded')) {
                $(this).removeClass('expanded');
                $(this).find('img').attr('src', img);
            } else {
                $(this).addClass('expanded');
                $(this).find('img').attr('src', altimg);
            }
        });
    }

    /**
     * Limit length of a text
     */
    if ($('.limit-text').length) {
        $('.limit-text').each(function() {
            var text = $(this).text();
            var len = $(this).data('length');
            if (text.length > len) {
                text = text.substring(0, len);
                $(this).text(text + '...');
            }
        });
    }

    /**
     * Set zoom on hover
     */
    if ($('.zoom-wrapper').length) {
        var _zoom = $('.zoom-wrapper').data('zoom');
        $('.zoom-wrapper').zoom({
            url: _zoom,
            touch: true,
            duration: 1000,
            on : 'click'
        });
    }

    /**
     * Set a select input to redirect on change
     */
    if ($('.select-href').length) {
        var _href;
        $('.select-href').change(function() {
            _href = $(this).val();
            if (_href) {
                document.location.href = _href;
            }
        });
    }

    /**
     * Set play button on a video cover
     * */
    if ($('.yt-player').length && $('.video-frame').length) {
        $('.video-frame').on('click', '.video-frame-play', function() {
            $(this).closest('.video-frame').addClass('playing-video');
            var _vid = $(this).closest('.video-frame').find('iframe').attr('id');
            var _p = YT.get(_vid);
            _p.playVideo();
        });
    }

    /**
     * Set form functionalities
     */
    if ($('form').length) {

        // Validator for CPF field
        jQuery.validator.addMethod("testCPF", function(value, element) {
            var Soma;
            var Resto;
            Soma = 0;
            value = value.replace('.', '');
            value = value.replace('.', '');
            value = value.replace('-', '');
            if (value == "00000000000" ||
                value == "11111111111" ||
                value == "22222222222" ||
                value == "33333333333" ||
                value == "44444444444" ||
                value == "55555555555" ||
                value == "66666666666" ||
                value == "77777777777" ||
                value == "88888888888" ||
                value == "99999999999") return false;
            for (i = 1; i <= 9; i++) Soma = Soma + parseInt(value.substring(i - 1, i)) * (11 - i);
            Resto = (Soma * 10) % 11;
            if ((Resto == 10) || (Resto == 11)) Resto = 0;
            if (Resto != parseInt(value.substring(9, 10))) return false;
            Soma = 0;
            for (i = 1; i <= 10; i++) Soma = Soma + parseInt(value.substring(i - 1, i)) * (12 - i);
            Resto = (Soma * 10) % 11;
            if ((Resto == 10) || (Resto == 11)) Resto = 0;
            if (Resto != parseInt(value.substring(10, 11))) return false;
            return true;
            return this.optional(element) || (parseFloat(value) > 0);
        }, "CPF inválido.");

        // CNPJ validation rule method
        jQuery.validator.addMethod("testCNPJ", function(c, element) {
            var b = [6,5,4,3,2,9,8,7,6,5,4,3,2];

            if((c = c.replace(/[^\d]/g,"")).length != 14)
                return false;

            if(/0{14}/.test(c))
                return false;

            for (var i = 0, n = 0; i < 12; n += c[i] * b[++i]);
            if(c[12] != (((n %= 11) < 2) ? 0 : 11 - n))
                return false;

            for (var i = 0, n = 0; i <= 12; n += c[i] * b[i++]);
            if(c[13] != (((n %= 11) < 2) ? 0 : 11 - n))
                return false;

            return true;
        }, "CNPJ Inválido");


        // Validator to check if a date is valid and not a future date
        jQuery.validator.addMethod("testDate", function(value, element) {
            var state = false;
            if ($(element).prop('required') === false && value.length === 0) {
                state = true;
            } else {
                if (value.length != 10) {
                    return false;
                } else {
                    var DateArr = value.split("/");
                    var day = DateArr[0];
                    var month = DateArr[1];
                    var year = DateArr[2];
                    if (month == '01' && (parseInt(day) > 0 && parseInt(day) <= 31)) { state = true; } else if (month == '02') {
                        if (leapYear(year)) {
                            if ((parseInt(day) > 0 && parseInt(day) <= 29)) {
                                state = true;
                            }
                        } else {
                            if ((parseInt(day) > 0 && parseInt(day) <= 28)) {
                                state = true;
                            }
                        }
                    } else if (month == '03' && (parseInt(day) > 0 && parseInt(day) <= 31)) { state = true; } else if (month == '04' && (parseInt(day) > 0 && parseInt(day) <= 30)) { state = true; } else if (month == '05' && (parseInt(day) > 0 && parseInt(day) <= 31)) { state = true; } else if (month == '06' && (parseInt(day) > 0 && parseInt(day) <= 30)) { state = true; } else if (month == '07' && (parseInt(day) > 0 && parseInt(day) <= 31)) { state = true; } else if (month == '08' && (parseInt(day) > 0 && parseInt(day) <= 31)) { state = true; } else if (month == '09' && (parseInt(day) > 0 && parseInt(day) <= 30)) { state = true; } else if (month == '10' && (parseInt(day) > 0 && parseInt(day) <= 31)) { state = true; } else if (month == '11' && (parseInt(day) > 0 && parseInt(day) <= 30)) { state = true; } else if (month == '12' && (parseInt(day) > 0 && parseInt(day) <= 31)) { state = true; }
                    var field_year = new Date(parseInt(year), (parseInt(month) - 1), parseInt(day));
                    var todayDate = new Date();
                    if (todayDate < field_year) {
                        state = false;
                    }
                }
            }
            return state;
        }, "Data inválida.");

        // Validator - changing default config for better highlights
        jQuery.validator.setDefaults({
            highlight: function(element, errorClass) {
                $(element).closest('.form-group').addClass('has-error').removeClass('is-valid');
            },
            unhighlight: function(element, errorClass) {
                $(element).closest('.form-group').removeClass('has-error').addClass('is-valid');
            }
        });

        // Call form validation
        $('.form-submit, .form-validate').each(function() {
            $(this).validate({
                focusInvalid: false,
                rules : {
                    "cpf" : { testCPF: true, required: true },
                    "cnpj" : { testCNPJ: true, required: true },
                    password : 'required',
                    confirm: {
                        equalTo: '#input-password'
                    }
                }
            });
        });

        // Set submit function
        $('.form-submit').submit(function(e) {
            e.preventDefault();
            $(this).validate();
            var _this = $(this);
            var form = $(this)[0];
            var recaptcha = $(this).closest('form').find(".g-recaptcha-response").val();
            var formAction = $(this).attr('action');
            var valid = $(this).valid();
            if(!valid){
                return false;
            } else {
                if (recaptcha === "") {
                    e.preventDefault();
                    swal('Erro', 'Preencha o reCAPTCHA', 'error');
                } else {
                    var btn = _this.find('button[type=\"submit\"]').html();
                    var btn_w = _this.find('button[type=\"submit\"]').width();
                    var dados = new FormData(form);
                    $.ajax({
                        url : formAction,
                        type: "POST",
                        data:  dados,
                        mimeType:"multipart/form-data",
                        contentType: false,
                        cache: false,
                        processData:false,
                        beforeSend: function() {
                            _this.find('button[type=\"submit\"]').html('<i class=\"fa fa-refresh fa-spin\"></i>').width(btn_w);
                        },
                        success: function(data){
                            if (data == 1) {
                                swal({
                                    title: "Sucesso",
                                    text: data.message ? data.message : "Envio realizado com sucesso",
                                    icon: "success",
                                    confirmButtonText: "Ok"
                                });
                                $('.modal.show').modal('hide');
                                _this[0].reset();
                            } else {
                                swal({
                                    title: "Erro",
                                    text: data.message ? data.message : "Erro no envio",
                                    icon: "error",
                                    confirmButtonText: "Fechar"
                                });
                            }
                            _this.find('button[type=\"submit\"]').html(btn);
                        },
                        error: function() {
                            _this.find('button[type=\"submit\"]').html(btn);
                        }
                    });
                }
            }
        });
    }

    /**
     * Custom link
     */
    if ($('.btn-a')) {
        $('.btn-a').on('click', function() {
            var href = $(this).data('href');
            setTimeout(function() {
                document.location.href = href;
            }, 800);

        });
    }

    /**
     * Set background on an element
     */
    if ($('.bk').length) {
        $('.bk').each(function() {
            var bk = $(this).data('bk');
            $(this).css('background-image', 'url(' + bk + ')');
        });
    }

    /**
     * Set scroll-to-top button
     */
    if ($('.scroller').length) {
        $(".scroller").click(function() {
            var windowPosition = $(window).scrollTop();
            var windowHeight = $(window).height();
            if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
                $('html, body').animate({
                    scrollTop : 0
                });
            } else {
                $('html, body').animate({
                    scrollTop : $(window).scrollTop() + windowHeight
                });
            }
        });
        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
                $('.scroller img').addClass('rotate-180');
            } else {
                $('.scroller img').removeClass('rotate-180');
            }
        });
    }

    /**
     * Set custom file input
     */
    if ($('.file-input').length) {
        $('.file-input').on('change', '.input-file', function() {
        var fileName = $(this).val().replace("C:\\fakepath\\","");
        if (fileName) {
            $(this).siblings('span').text(fileName);
            $(this).parent().addClass('has-file');
        } else {
            var message = $(this).siblings('span').data('message');
            $(this).siblings('span').text(message);
            $(this).parent().removeClass('has-file');
        }
        });
    }

    /**
     * Set smooth anchor scrolling
     */
    if ($('.scroll-to').length) {
        $('.scroll-to').click(function(e) {
            e.preventDefault();
            var anchor = $(this).attr('href');
            var pos = $(anchor).offset().top + $(window).height();
            $('html, body').animate({
                scrollTop: pos
            }, 1200, function() {
                $(anchor).find('input[type=\"text\"]').eq(0).focus();
            });
        });
    }

    /**
     * Set current your
     */
    if ($('.current-year').length) {
        var year = (new Date()).getFullYear();
        $('.current-year').text(year);
    }

    /**
     * Set Venobox Plugin
     */
    if ($('.venobox').length) {
        $('.venobox').venobox({
            titleattr: 'data-title'
        });
    }

    /**
     * Custom File Input Config
     */
    if ($('.file-label').length) {
        $(document).on('change', '.file-label input', function() {
            var path = $(this).val();
            if (path) {
            var filename = path.replace(/^.*\\/, "");
            $(this).closest('.file-label').addClass('has-file').find('span').html('<i class="fa fa-times"></i> ' + filename);
            } else {
            $(this).closest('.file-label').removeClass('has-file').find('span').html('<i class="fa fa-upload"></i> Escolha um arquivo para enviar');
            }
        });
        $(document).on('click', '.file-input .fa-times', function(e){
            e.preventDefault();
            $(this).closest('.file-input').find('input[type="file"]').val('');
            $(this).closest('.file-label').removeClass('has-file').find('span').html('<i class="fa fa-upload"></i> Escolha um arquivo para enviar');
        });
    }

    /**
     * Field selector for Custom Checkbox
     */
    if ($('.field-selector').length) {
        $(document).on('change','.field-selector .custom-control-input', function() {
            var _target = $(this).val();
            $(this).closest('.field-selector').find('.form-group').removeClass('active');
            $(this).closest('.field-selector').find('[name=\"' + _target + '\"]').closest('.form-group').addClass('active');
        });
    }

    $(document).on('click', '.btn-drop', function() {
        if ($(this).find('.drop-area').hasClass('active')) {
            $(this).find('.drop-area').removeClass('active');
        } else {
            $(this).find('.drop-area').addClass('active');
        }
    });

    /**
     * Eventos que permitem ao usuário editar um formulário que está como readonly.
     */
    $(document).on('click', '.edit-form', function() { // Começar a editar
        $('.editable-form').removeClass('editing').addClass('disabled');
        $(this).closest('.form-group').find("button").toggle();
        $(this).closest('form').find('input, select').prop('readonly', false);
        $(this).closest('form').find('.custom-control-holder').removeClass('disabled');
        $(this).closest('form').removeClass('disabled').addClass('editing');
        $(this).closest('form').find('input').eq(0).focus();
    });

    $(document).on('click', '.cancel-form', function() { // Cancelar edição
        $(this).closest('.form-group').find("button").toggle();
        $(this).closest('form').find('input, select').prop('readonly', true);
        $(this).closest('form').find('.custom-control-holder').addClass('disabled');
        $(this).closest('form').addClass('disabled').removeClass('editing');
    });

    $(document).on('submit', '.editable-form.editing', function(e) { // Salvar edição
        e.preventDefault();
        var _this = $(this);
        var _url = _this.attr('action');
        var _btn = _this.find('button:submit').html();
        _this.find('button:submit').html('<i class="fa fa-refresh fa-spin"></i>');
        var _dados = _this.serialize();
        $.ajax({
            url: $('base').attr('href') + _url,
            data: _dados,
            method: "post",
            success: function(res) {
            if (res == 1) {
                swal({
                "title" : "Sucesso!",
                "text" : "Suas informações foram salvas com sucesso!",
                "icon" : "success"
                }).then(function() {
                    setTimeout(function() {
                        _this.find("button:submit").html(_btn);
                        _this.find('button:submit').closest('.form-group').find("button").toggle();
                        _this.find('input, select').prop('readonly', true);
                        _this.find('.custom-control-holder').addClass('disabled');
                        _this.addClass('disabled').removeClass('editing');
                    }, 50);
                });
            } else {
                swal({
                "title" : "Erro!",
                "text" : "Não foi possível salvar seus dados!",
                "icon" : "error"
                }).then(function() {
                setTimeout(function() {
                    _this.find("button:submit").html(_btn);
                    _this.find('input').eq(0).focus();
                }, 50);
                });
            }
            },
            error: function(x, y, z) {
            _this.find('button:submit').html(_btn);
            console.error(x);
            console.error(y);
            console.error(z);
            _this.find('button:submit').closest('.form-group').find("button").toggle();
            _this.find('input, select').prop('readonly', true);
            _this.find('.custom-control-holder').addClass('disabled');
            _this.addClass('disabled').removeClass('editing');
            }
        });
    });

    /**
     * Basic search with AJAX
     */
    var _search_label = $('#search-label').html();
    var _first_search = true;
    $(document).on('keyup', '#search', function() {
        if ($(this).val().length > 2) {
            $.ajax({
                url: base + "requisicoes/busca.php",
                type: 'post',
                dataType: 'json',
                beforeSend : function (event, ui) {
                    $('#search-label').html("Buscando <i class='fa fa-refresh fa-spin'></i>");
                },
                success : function (response) {
                    $('#search-results .mCSB_container').html('');
                    if (_first_search) {
                        _first_search = false;
                        $('#search-results').mCustomScrollbar({ theme : 'dark' });
                    }
                    if (response.status == '1') {
                        var count = 0;
                        $.each(response.resultados, function(index, value) {
                            var li = '<li><a href="' + value.link + '">';
                            li += '<img src="' + value.imagem + '" alt="">';
                            li += '<h4>' + value.titulo + '</h4>';
                            li += '<span>' + value.resumo + '</span></a></li>';
                            $('#search-results .mCSB_container').append(li);
                            $('#search-results').mCustomScrollbar('update');
                            count++;
                        });
                    }
                    if (count == 0) {
                        $('#search-label').html('Nenhum resultado para sua busca.');
                    } else {
                        $('#search-label').html(count + ' resultados');
                    }
                },
                error : function(x,y,z) {
                    console.error(x);
                    console.error(y);
                    console.error(z);
                    $('#search-label').html(_search_label);
                }
            });
        } else {
            $('#search-label').html(_search_label);
            $('#search-results .mCSB_container').html('');
        }
    });

    $('#search-toggler, #search-wrapper .dismiss').click(function() {
        $('#search').val('');
        $('#search-wrapper').toggleClass('active');
        $('#search-label').html(_search_label);
        $('#search-results').html('');
    });

    /**
     * Nice input styling and functionality settings
     */
    $(document).on('blur', '.nice-input', function() {
        var _val = $(this).val();
        if (_val) {
            $(this).addClass('filled');
        } else {
            $(this).removeClass('filled');
        }
    });

});

var resizeTimer;

$(window).on('resize', function(e) {

  clearTimeout(resizeTimer);
  resizeTimer = setTimeout(function() {

    $('#search-results').mCustomScrollbar('update');

  }, 250);

});

/**
   * Aceite Cookies
   */
if ($('.cookies-background').length) {
  $(document).on('click', '.cookies .dismiss-cookies', function(event) {
    event.preventDefault();
    $('.cookies-background').fadeOut('500', function() {
      $('.cookies-background').remove();
    });
  });
}

window.onload = function() {
    if ($('#map').length) {
        loadScript();
    }

    if ($('.cookies-background').length) {
        setTimeout(function(){
            $('.cookies-background').fadeIn('500');
        }, 1500);
    }

    $('.loader').fadeOut(300, function() {
        if ($('.wow').length) {
            new WOW().init();
        }
    },0);
}

//  $(document).ready(function(){
//     /**
//     Config. da DataTable da página
//     */
//     var leads_table = $('#gisa-dt');
//     var _dt_options = {
//         "language":{
//             "url": "./js/Portuguese-Brasil.json"
//         },
//         "ordering": true,
//         "order" : [ 0, "asc" ],
//         "paging": true,
//         "searching": true,
//         "info": false,
//         responsive : true
//     };

//     leads_table.DataTable(_dt_options);
// });