$(document).ready(function () {



    var numitens = 10; //quantidade de itens a ser mostrado por página

    var pagina = 1;	//página inicial - DEIXE SEMPRE 1

    var url = window.location.pathname.split('/');

    

    getitens(pagina, numitens); //Chamando função que lista os itens



    function getitens(pag, maximo) {

        pagina = pag;

        $.ajax({

            type: 'GET',

            data: 'tipo=listagem&pag=' + pag + '&maximo=' + maximo + '&onde=' + url[3],

            url: '',

            success: function (retorno) {

                $('#message-list').html(retorno);

                contador() //Chamando função que conta os itens e chama o paginador

            }

        });

    }



    function contador() {

        $.ajax({

            type: 'GET',

            data: 'tipo=contador&onde=' + url[3],

            url: '',

            success: function (retorno_pg) {

                paginacao(retorno_pg)

            }

        });

    }



    function paginacao(cont) {

        if (cont <= numitens) {

            $('#paginacao').html('');

        } else {

            $('#paginacao').html('<nav><ul class="pagination pull-right"></ul></nav>');

            if (pagina != 1) {

                $('#paginacao ul').append('<li><span><a href="#" onclick="getitens(' + (pagina - 1) + ', ' + numitens + ')"><i class="ace-icon fa fa-caret-left bigger-140 middle"></i></span></a></li>')

            }

            var qtdpaginas = Math.ceil(cont / numitens)

            for (var i = 1; i <= qtdpaginas; i++) {

                if (pagina == i) {

                    $('#paginacao ul').append('<li class="active"><a href="#" onclick="getitens(' + i + ', ' + numitens + ')">' + i + '</a></li>')

                } else {

                    $('#paginacao ul').append('<li><a href="#" onclick="getitens(' + i + ', ' + numitens + ')">' + i + '</a></li>')

                }

            }

            if (pagina != qtdpaginas) {

                $('#paginacao ul').append('<li><span><a href="#" onclick="getitens(' + (pagina + 1) + ', ' + numitens + ')"><i class="ace-icon fa fa-caret-right bigger-140 middle"></i></span></a></li>')

            }

        }

    }



    $('[data-toggle="tooltip"]').tooltip();



    $('.datepicker').daterangepicker({singleDatePicker: true}, function (start, end, label) {

        console.log(start.toISOString(), end.toISOString(), label);

    });



    $('#search-nodata').hideseek({

        nodata: 'Não há resultados',

        highlight: true,

        ignore: '.ignore',

        navigation: true

    });



    $('.ordenacao').click(function () {

        var tipo = $(this).attr('id');

        if (tipo == 'nome') {

            $('.ord2').addClass('green');

            $('.ord').removeClass('green');

            $('.ord2').removeClass('invisible');

            $('.ord').addClass('invisible');

        } else {

            $('.ord').addClass('green');

            $('.ord2').removeClass('green');

            $('.ord').removeClass('invisible');

            $('.ord2').addClass('invisible');

        }

        $.ajax({

            type: "POST",

            url: "ordenacao_mensagem.php",

            data: "var=" + tipo + "&tabela=contato",

            success: function (retorno) {

                $('#message-list').html(retorno);

            }

        });

    });    






    $('#tag').click(function () {

        $('#abrir_tag').slideToggle();

    });



    $('#galeria').click(function () {

        $('#abrir_galeria').slideToggle();

    });



    $('#galeria_lancamento').click(function () {

        $('#abrir_galeria2').slideToggle();

    });



    $(function () {

        $("#sortable").sortable({

            placeholder: "ui-state-highlight"

        });

        $("#sortable").disableSelection();

    });



    $('.ordenar').click(function () {

        var tr = '';

        var pag = $(this).attr('id');

        $('.ui-sortable-handle').each(function () {

            tr = tr + $(this).attr('id').replace('tr', '') + ',';

        });

        $.ajax({

            type: "POST",

            url: "dados/atualiza_ordem.php",

            data: "var=" + tr + "&pag=" + pag,

            success: function (retorno) {

                location.reload();

            }

        });

    });



    $('#envia_google').click(function () {

        $('#google').submit(function () {

            var dados = $(this).serialize();

            $.ajax({

                type: "POST",

                url: "",

                data: dados,

                success: function (data) {

                    if (data == 1) {

                        alert('Codigo cadastrado com sucesso!');

                    } else {

                        alert('Erro ao cadastrar o codigo');

                    }

                }

            });

            return false;

        });

    });



    $('#envia_home').click(function () {

        $('#meta_tag').submit(function () {

            var dados = $(this).serialize();

            $.ajax({

                type: "POST",

                url: "",

                data: dados,

                success: function (data) {

                    if (data == 1) {

                        alert('Meta tag cadastrado com sucesso!');

                    } else {

                        alert('Erro ao cadastrar a meta tag');

                    }

                }

            });

            return false;

        });

    });  



    $('#cadastra_tag').click(function () {

        $('#form_tag').submit(function () {

            var dados = $(this).serialize();

            $.ajax({

                type: "POST",   

                url: "",

                data: dados,

                success: function (data) {

                    if (data == 1) {

                        alert('Meta tag cadastrado com sucesso!');

                    } else {

                        alert('Erro ao cadastrar a meta tag');

                    }

                }

            });

            return false;

        });

    });

});