$(function () {

    // Click event handler for the generateSitemapButton
    $('#generateSitemapButton').click(function () {
        $(this).attr('disabled', true);
        $(this).addClass('disable');
        $.ajax({
            url: Ajaxrequest() + '?t=admin&a=generatesitemap',
            type: 'POST', // HTTP method for the request
            success: function (data) {
                if (data.status == 200) {
                    Toast.success(data.success_message);
                } else {
                    Toast.error(data.error_message);
                }
                $('#generateSitemapButton').attr('disabled', false);
                $('#generateSitemapButton').removeClass('disable');
            }
        });
    });

    $(document).ready(function () {
        $(document).on('click', '.game_type-import', function () {
            var __rEi = $(this);
            __addgame_showImport(__rEi);
        });

        function __addgame_showImport(game_type_import) {
            var __It1 = $('#game_import0');
            var __It0 = $('#game_import1');
            var __ValIt = $('.game_type-import--val');

            if (game_type_import.hasClass('i-t-1')) {
                __It0.show();
                __It1.hide();
                __ValIt.attr('value', 1);
            } else if (game_type_import.hasClass('i-t-0')) {
                __It1.show();
                __It0.hide();
                __ValIt.attr('value', 0);
            }

        }

        $(document).on('click', '.game_state-E', function () {
            var __rHs = $(this);
            __addgame_State(__rHs);
        });

        function __addgame_State(__sId) {
            var __Vals1 = $('.game_published--val');
            var __Vals2 = $('.game_featured--val');

            if (__sId.hasClass('s-t-P')) {
                if (__Vals1.val() == 1) {
                    __Vals1.attr('value', 0);
                } else {
                    __Vals1.attr('value', 1);
                }
            } else if (__sId.hasClass('s-t-F')) {
                if (__Vals2.val() == 1) {
                    __Vals2.attr('value', 0);
                } else {
                    __Vals2.attr('value', 1);
                }
            }
        }

        $(document).on('click', '.report-btn-action', function () {
            var __rHs = $(this);
            __rp_actEx(__rHs);
        });

        function __rp_actEx($bThis) {
            var _actTy = $bThis.attr('data-rp-action');
            var _rp_Inf = $bThis.attr('data-rp-id');
            if (_actTy == 1) {
                var _rp_Usr = $bThis.attr('data-user');
                $.ajax({
                    url: Ajaxrequest() + '?t=admin&a=act_report',
                    type: 'POST',
                    data: "uid=" + _rp_Usr + "&rp_id=" + _rp_Inf,
                    success: function () {
                        $('.report-r' + _rp_Inf).slideToggle(200, function () {
                            $(this).remove();
                        });
                    }
                });
            } else if (_actTy == 2) {
                $.ajax({
                    url: Ajaxrequest() + '?t=admin&a=act_report',
                    type: 'POST',
                    data: "rp_id=" + _rp_Inf,
                    success: function () {
                        $('.report-r' + _rp_Inf).slideToggle(200, function () {
                            $(this).remove();
                        });
                    }
                });
            }
        }
    });

    /* ADD GAME */
    var addgame_bar = $('.addgame_bar');
    var addprogress = $('.addgame_progress');

    $('#addgame-form').ajaxForm({
        url: Ajaxrequest() + '?t=admin&a=addgame',
        type: 'POST',
        beforeSend: function () {
            form_h = $('.addgame-header');
            addgame_btn = form_h.find('#addgame-btn');
            addgame_btn.attr('disabled', true);
            var ag_pV = '0%';
            addgame_bar.width(ag_pV)
        },
        uploadProgress: function (event, position, total, percentComplete) {
            addprogress.show()
            var ag_pV = percentComplete + '%';
            addgame_bar.width(ag_pV)
            //console.log(ag_pV, position, total);
        },
        success: function (data) {
            if (data.status == 200) {
                addprogress.hide()
                addgame_bar.width('0%')
                document.getElementById('addgame-form').reset();
                Toast.success(data.success_message);
            }
            else {
                addprogress.hide()
                addgame_bar.width('0%')
                Toast.error(data.error_message);
            }
            addgame_btn.attr('disabled', false);
        }
    });


    /* EDIT GAME */
    var editgame_bar = $('.editgame_bar');
    $('#addgame-btn2').click(function () {
        $('#addgame-btn').trigger('click');
        tinymce.triggerSave();
    });
    $('#addgame-btn').click(function () {
        tinymce.triggerSave();
    });
    $('#editgame-form').ajaxForm({
        url: Ajaxrequest() + '?t=admin&a=editgame',
        type: 'POST',
        beforeSend: function () {
            form_h = $('.editgame-header');
            addgame_btn = form_h.find('#addgame-btn');
            addgame_btn.attr('disabled', true);
            var eg_pV = '0%';
            editgame_bar.width(eg_pV)
            eg_m_uploadInput = $('#_-2m-f');
            eg_f_uploadInput = $('#_-3f-f');
        },
        uploadProgress: function (event, position, total, percentComplete) {
            var eg_pV = percentComplete + '%';
            editgame_bar.width(eg_pV)
            //console.log(eg_pV, position, total);
        },
        success: function (data) {
            if (data.status == 200) {
                $('#editgame_image').attr('src', data.game_img);
                $('#editgame_name').text(data.game_name);
                eg_m_uploadInput.replaceWith(eg_m_uploadInput.val('').clone(true));
                eg_f_uploadInput.replaceWith(eg_f_uploadInput.val('').clone(true));

                Toast.success(data.success_message);
                location.reload();
            }
            else {
                Toast.error(data.error_message);
            }
            addgame_btn.attr('disabled', false);
        }
    });

    /* MANAGE GAMES */
    $(document).ready(function () {
        $(document).on('click', '#mg--published', function () {
            var _mg_eXid = $(this).attr('data-game');
            var _mg_eXpb = $('.mg_p-' + _mg_eXid).attr('data-pb');
            __ajaxManageStatusGame(_mg_eXid, _mg_eXpb, 1);
        });

        $(document).on('click', '#mg--featured', function () {
            var _mg_eXid = $(this).attr('data-game');
            var _mg_eXpb = $('.mg_f-' + _mg_eXid).attr('data-ft');
            __ajaxManageStatusGame(_mg_eXid, _mg_eXpb, 2);
        });

        $(document).on('click', '#mg--delete', function () {
            var _mg_eXid = $(this).attr('data-game');
            __ajaxManageStatusGame(_mg_eXid, 0, 3);
        });

        function __ajaxManageStatusGame(gid, ss, tp) {
            if (tp == 1) {
                $.ajax({
                    url: Ajaxrequest() + '?t=admin&a=mg_published',
                    type: 'POST',
                    data: "gid=" + gid,
                    success: function () {
                        var _pd4 = $('.mg_p-' + gid);
                        if (ss == 1) {
                            _pd4.removeClass('pub-active');
                            _pd4.attr('data-pb', '0');
                        } else {
                            _pd4.addClass('pub-active');
                            _pd4.attr('data-pb', '1');
                        }
                    }
                });
            } else if (tp == 2) {
                $.ajax({
                    url: Ajaxrequest() + '?t=admin&a=mg_featured',
                    type: 'POST',
                    data: "gid=" + gid,
                    success: function () {
                        var _ft0 = $('.mg_f-' + gid);
                        if (ss == 1) {
                            _ft0.removeClass('feat-active');
                            _ft0.attr('data-ft', '0');
                        } else {
                            _ft0.addClass('feat-active');
                            _ft0.attr('data-ft', '1');
                        }
                    }
                });
            } else if (tp == 3) {
                $.ajax({
                    url: Ajaxrequest() + '?t=admin&a=mg_delete',
                    type: 'POST',
                    data: "gid=" + gid,
                    success: function () {
                        var _dlt9 = $('.__mg-' + gid);
                        _dlt9.slideToggle(200, function () {
                            $(this).remove();
                        });
                    }
                });
            }
        }
    });

    /* MANAGE CATEGORIES */

    /* ADD GAME */
    var addcategory_bar = $('.addcategory_bar');
    var addcategoryprogress = $('.addcategory_progress');

    $('#addcategory-form').ajaxForm({
        url: Ajaxrequest() + '?t=admin&a=addcategory',
        type: 'POST',
        beforeSend: function () {
            form_h = $('.addcategory-header');
            addcategory_btn = form_h.find('#addcategory-btn');
            addcategory_btn.attr('disabled', true);
            var ag_pV = '0%';
            addcategory_bar.width(ag_pV)
        },
        uploadProgress: function (event, position, total, percentComplete) {
            addcategoryprogress.show()
            var ag_pV = percentComplete + '%';
            addcategory_bar.width(ag_pV)
            //console.log(ag_pV, position, total);
        },
        success: function (data) {
            if (data.status == 200) {
                addcategoryprogress.hide()
                addcategory_bar.width('0%')
                document.getElementById('addcategory-form').reset();
                Toast.success(data.success_message);
            }
            else {
                addcategoryprogress.hide()
                addcategory_bar.width('0%')
                Toast.error(data.error_message);
            }
            addcategory_btn.attr('disabled', false);
        }
    });

    $('#editcategory-form').ajaxForm({
        url: Ajaxrequest() + '?t=admin&a=editcategory',
        type: 'POST',
        beforeSend: function () {
            form_h = $('.addcategory-header');
            addcategory_btn = form_h.find('#addcategory-btn');
            addcategory_btn.attr('disabled', true);
            var ag_pV = '0%';
            addcategory_bar.width(ag_pV)
        },
        uploadProgress: function (event, position, total, percentComplete) {
            addcategoryprogress.show()
            var ag_pV = percentComplete + '%';
            addcategory_bar.width(ag_pV)
            //console.log(ag_pV, position, total);
        },
        success: function (data) {
            if (data.status == 200) {
                addcategoryprogress.hide()
                addcategory_bar.width('0%')
                Toast.success(data.success_message);
            }
            else {
                addcategoryprogress.hide()
                addcategory_bar.width('0%')
                Toast.error(data.error_message);
            }
            addcategory_btn.attr('disabled', false);
        }
    });

    $(document).ready(function () {
        $(document).on('click', '#mc--delete', function () {
            var _mc_eXcid = $(this).attr('data-category');
            __dltCtgr7(_mc_eXcid);
        });

        function __dltCtgr7(cid) {
            $.ajax({
                url: Ajaxrequest() + '?t=admin&a=mc_delete',
                type: 'POST',
                data: "cid=" + cid,
                success: function () {
                    var _cdlt3 = $('.__mc-' + cid);
                    _cdlt3.slideToggle(200, function () {
                        $(this).remove();
                    });
                }
            });
        }
    });

    /* MANAGE TAGS */
    $('#addtags-form').ajaxForm({
        url: Ajaxrequest() + '?t=admin&a=addtags',
        type: 'POST',
        beforeSend: function () {
            form_h = $('.addtags-header');
            addtags_btn = form_h.find('#addtags-btn');
            addtags_btn.attr('disabled', true);
        },
        success: function (data) {
            if (data.status == 200) {
                document.getElementById('addtags-form').reset();
                Toast.success(data.success_message);
            }
            else {
                Toast.error(data.error_message);
            }
            addtags_btn.attr('disabled', false);
        }
    });

    $('#edittags-form').ajaxForm({
        url: Ajaxrequest() + '?t=admin&a=edittags',
        type: 'POST',
        beforeSend: function () {
            form_h = $('.addtags-header');
            addtags_btn = form_h.find('#addtags-btn');
            addtags_btn.attr('disabled', true);
        },
        success: function (data) {
            if (data.status == 200) {
                Toast.success(data.success_message);
                location.reload();
            }
            else {
                Toast.error(data.error_message);
            }
            // addtest_btn.attr('disabled', false);
        }
    });

    $(document).ready(function () {
        $(document).on('click', '#mc-tags-delete', function () {
            var _mc_eXcid = $(this).attr('data-tags');
            __dltCtgr7(_mc_eXcid);
        });

        function __dltCtgr7(cid) {
            $.ajax({
                url: Ajaxrequest() + '?t=admin&a=mc_tags_delete',
                type: 'POST',
                data: "cid=" + cid,
                success: function () {
                    var _cdlt3 = $('.__mc-' + cid);
                    _cdlt3.slideToggle(200, function () {
                        $(this).remove();
                    });
                }
            });
        }

        $(document).on('click', '.clickToCopy', function (e) {
            e.preventDefault();
            var link = $(this).attr('href');
            var name = $(this).attr('data-name');
            link = `<a href="${link}">${name}</a>`;
            navigator.clipboard.writeText(link);
        });

        $(document).on('click', '.clickToCopyText', function (e) {
            e.preventDefault();
            var text = $(this).attr('data-text');
            navigator.clipboard.writeText(text);
        });

        $(document).on('click', '.rewriteText', function (e) {
            e.preventDefault();
            var rewriteTemplate = $(this).attr('data-text');
            var rewriteMethod = $(this).attr("data-method");
            var originalDescription = $(".eg_description").val();

            if (rewriteMethod === undefined) {
                rewriteMethod = "rewritechatgpt";
            }
            $('.rewriteText').addClass('btn-w');
            $('.rewriteText').css('pointer-events', 'none');
            $.ajax({
                url: Ajaxrequest() + '?t=admin&a=' + rewriteMethod,
                type: 'POST',
                data: `game_id=${$('.eg_id').val()}&text=${rewriteTemplate}&originalText=${originalDescription}`,
                beforeSend: function () {
                    Toast.info('Rewriting, please wait...', '', {
                        displayDuration: 0
                    });
                },
                success: function (response) {
                    if (response.status == 200) {
                        Toast.success('Success');
                        $('.rewriteResultBox').show();
                        $('.rewriteResult').text(response.rewrite_result);
                        $('.rewriteResultBox .clickToCopyText').attr("data-text", response.rewrite_result);
                        $('.rewriteResult').text(response.rewrite_result);
                        if (rewriteMethod === "rewritechatgpt") {
                            $('.rewriteOpenAI').remove();
                        }
                    } else {
                        Toast.error(response.error_message);
                    }
                },
                complete: function () {
                    $('.toast-info').remove();
                    $('.rewriteText').removeClass('btn-w');
                    $('.rewriteText').css('pointer-events', 'all');
                }
            });
        });

        $(document).on('click', '.rewriteTextCategory', function (e) {
            e.preventDefault();
            $.ajax({
                url: Ajaxrequest() + '?t=admin&a=chatgptrewritecategory',
                type: 'POST',
                data: `cat_id=${$('.ec_id').val()}`,
                success: function (response) {
                    // console.log(response);
                }
            });
        });

        $(document).on('click', '.rewriteTextTags', function (e) {
            e.preventDefault();
            $.ajax({
                url: Ajaxrequest() + '?t=admin&a=chatgptrewritetags',
                type: 'POST',
                data: `tag_id=${$('.ec_id').val()}`,
                success: function (response) {
                    // console.log(response);
                }
            });
        });

        $(document).on('click', '.rewriteTextFooter', function (e) {
            e.preventDefault();
            $.ajax({
                url: Ajaxrequest() + '?t=admin&a=chatgptrewritefooter',
                type: 'POST',
                data: `footer_id=${$('.id').val()}`,
                success: function (response) {
                    // console.log(response);
                }
            });
        });

        $(document).on('click', '.linksEnableDisable', function (e) {
            e.preventDefault();
            $.ajax({
                url: Ajaxrequest() + '?t=admin&a=linksenabledisable',
                type: 'POST',
                data: `links_id=${$(this).attr('data-id')}`,
                success: function (response) {
                    location.reload();
                }
            });
        });

        $(document).on('click', '#uploadGameDescriptionButton', function (e) {
            e.preventDefault();
            var file_data = $('#gameDescriptionFile').prop('files')[0];
            var form_data = new FormData();
            form_data.append('file', file_data);

            Toast.info("Upload in progres, please wait.");

            $.ajax({
                url: Ajaxrequest() + '?t=admin&a=gamedescriptionupload',
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                data: form_data,
                success: function (data) {
                    // location.reload();
                    data = JSON.parse(data);
                    if (data.status == 200) {
                        Toast.success(data.success_message);
                    } else {
                        Toast.error(data.error_message);
                    }
                    console.log(data.status);
                },
                error: function () {
                    console.log('error upload');
                }
            });
        });

        $(document).on('click', '.downloadGameDescriptionButton', function (e) {
            location.href = '/admin/gameDescriptionDownload';
        });
    });

    /* MANAGE FOOTER DESCRIPTION */
    $('#editfooterdescription-form').ajaxForm({
        url: Ajaxrequest() + '?t=admin&a=editfooterdescription',
        type: 'POST',
        beforeSend: function () {
            form_h = $('.addfooterdescription-header');
            addfooterdescription_btn = form_h.find('#addfooterdescription-btn');
            addfooterdescription_btn.attr('disabled', true);
        },
        success: function (data) {
            if (data.status == 200) {
                Toast.success(data.success_message);
                location.reload();
            }
            else {
                Toast.error(data.error_message);
            }
        }
    });

    /* MANAGE BLOGS */
    var addblog_bar = $('.addblog_bar');
    var addblogprogress = $('.addblog_progress');

    $('#addblog-form').ajaxForm({
        url: Ajaxrequest() + '?t=admin&a=addblog',
        type: 'POST',
        beforeSend: function () {
            form_h = $('.addblog-header');
            addblog_btn = form_h.find('#addblog-btn');
            addblog_btn.attr('disabled', true);
        },
        success: function (data) {
            if (data.status == 200) {
                location.href = data.redirect_url;
                Toast.success(data.success_message);
            }
            else {
                Toast.error(data.error_message);
            }
            addblog_btn.attr('disabled', false);
        }
    });

    $('#editblog-form').ajaxForm({
        url: Ajaxrequest() + '?t=admin&a=editblog',
        type: 'POST',
        beforeSend: function () {
            form_h = $('.addblog-header');
            addblog_btn = form_h.find('#addblog-btn');
            addblog_btn.attr('disabled', true);
            var ag_pV = '0%';
            addblog_bar.width(ag_pV)
        },
        uploadProgress: function (event, position, total, percentComplete) {
            addblogprogress.show()
            var ag_pV = percentComplete + '%';
            addblog_bar.width(ag_pV)
            //console.log(ag_pV, position, total);
        },
        success: function (data) {
            if (data.status == 200) {
                addblogprogress.hide()
                addblog_bar.width('0%')
                Toast.success(data.success_message);
                location.reload();
            }
            else {
                addblogprogress.hide()
                addblog_bar.width('0%')
                Toast.error(data.error_message);
            }
            addblog_btn.attr('disabled', false);
        }
    });

    $(document).ready(function () {
        $(document).on('click', '#mc-blog-delete', function () {
            var _mc_eXcid = $(this).attr('data-blog');
            __dltCtgr7(_mc_eXcid);
        });

        function __dltCtgr7(cid) {
            $.ajax({
                url: Ajaxrequest() + '?t=admin&a=mc_blogs_delete',
                type: 'POST',
                data: "cid=" + cid,
                success: function () {
                    var _cdlt3 = $('.__mc-' + cid);
                    _cdlt3.slideToggle(200, function () {
                        $(this).remove();
                    });
                }
            });
        }
    });
    /* MANAGE SETTING */
    $('#adminsetting-form').ajaxForm({
        url: Ajaxrequest() + '?t=admin&a=setting',
        type: 'POST',
        success: function (data) {
            if (data.status == 200) {
                Toast.success(data.success_message);
            }
            else {
                Toast.error(data.error_message);
            }
        }
    });

    /* MANAGE USERS */
    $('#edituser-form').ajaxForm({
        url: Ajaxrequest() + '?t=admin&a=edituser',
        type: 'POST',
        success: function (data) {
            if (data.status == 200) {
                Toast.success(data.success_message);
            } else {
                Toast.error(data.error_message);
            }
        }
    });

    /* SEARCH USERS TO EDIT */
    $('#search-useredit-form').ajaxForm({
        url: Ajaxrequest() + '?t=admin&a=searchUserEdit',
        type: 'POST',
        success: function (data) {
            if (data.status == 200) {
                window.location = data.redirect_url;
            } else {
                Toast.error(data.error_message);
            }
        },
        error: function () {
            console.log('Connection failed!');
        }
    });

    /* MANAGE ADS AREA */
    $('#adsArea-form').ajaxForm({
        url: Ajaxrequest() + '?t=admin&a=manageAdsArea',
        type: 'POST',
        success: function (data) {
            if (data.status == 200) {
                Toast.success(data.success_message);
            }
        }
    });

    /* MANAGE ADS AREA */
    $('#adsTxtArea-form').ajaxForm({
        url: Ajaxrequest() + '?t=admin&a=manageAdsTxtArea',
        type: 'POST',
        success: function (data) {
            if (data.status == 200) {
                Toast.success(data.success_message);
            }
        }
    });

    /* MANAGE CHATGPT */
    $('#chatgptArea-form').ajaxForm({
        url: Ajaxrequest() + '?t=admin&a=chatgpt',
        type: 'POST',
        success: function (data) {
            if (data.status == 200) {
                Toast.success(data.success_message);
            }
        }
    });

    /* MANAGE LINKS */
    $('#updatelink-form').ajaxForm({
        url: Ajaxrequest() + '?t=admin&a=linksupdate',
        type: 'POST',
        success: function (data) {
            if (data.status == 200) {
                Toast.success(data.success_message);
                location.reload();
            }
            else {
                Toast.error(data.error_message);
            }
        }
    });

    /* MANAGE SLIDERS */
    var addslider_bar = $('.addslider_bar');
    var addsliderprogress = $('.addslider_progress');

    $('#addslider-form').ajaxForm({
        url: Ajaxrequest() + '?t=admin&a=slidersadd',
        type: 'POST',
        beforeSend: function () {
            form_h = $('.addslider-header');
            addslider_btn = form_h.find('#addslider-btn');
            addslider_btn.attr('disabled', true);
            var ag_pV = '0%';
            addslider_bar.width(ag_pV)
        },
        success: function (data) {
            if (data.status == 200) {
                addsliderprogress.hide()
                addslider_bar.width('0%')
                document.getElementById('addslider-form').reset();
                location.href = data.href;
                Toast.success(data.success_message);
            }
            else {
                addsliderprogress.hide()
                addslider_bar.width('0%')
                Toast.error(data.error_message);
            }
            addslider_btn.attr('disabled', false);
        }
    });

    $('#editslider-form').ajaxForm({
        url: Ajaxrequest() + '?t=admin&a=slidersedit',
        type: 'POST',
        beforeSend: function () {
            form_h = $('.addslider-header');
            addslider_btn = form_h.find('#addslider-btn');
            addslider_btn.attr('disabled', true);
        },
        success: function (data) {
            if (data.status == 200) {
                Toast.success(data.success_message);
                location.reload();
            }
            else {
                Toast.error(data.error_message);
            }
            // addtest_btn.attr('disabled', false);
        }
    });

    $(document).ready(function () {
        $(document).on('click', '#mc-slider-delete', function () {
            __dltCtgr7($(this).attr('data-sliders'));
        });
        function __dltCtgr7(cid) {
            console.log(cid);
            $.ajax({
                url: Ajaxrequest() + '?t=admin&a=slidersdelete',
                type: 'POST',
                data: "cid=" + cid,
                success: function () {
                    var _cdlt3 = $('.__mc-' + cid);
                    _cdlt3.slideToggle(200, function () {
                        $(this).remove();
                    });
                }
            });
        }
    });

    /* MANAGE SIDEBAR */
    var addsidebar_bar = $('.addsidebar_bar');
    var addsidebarprogress = $('.addsidebar_progress');

    $('#addsidebar-form').ajaxForm({
        url: Ajaxrequest() + '?t=admin&a=sidebaradd',
        type: 'POST',
        beforeSend: function () {
            form_h = $('.addsidebar-header');
            addsidebar_btn = form_h.find('#addsidebar-btn');
            addsidebar_btn.attr('disabled', true);
            var ag_pV = '0%';
            addsidebar_bar.width(ag_pV)
        },
        success: function (data) {
            if (data.status == 200) {
                addsidebarprogress.hide()
                addsidebar_bar.width('0%')
                document.getElementById('addsidebar-form').reset();
                location.href = data.href;
                Toast.success(data.success_message);
            }
            else {
                addsidebarprogress.hide()
                addsidebar_bar.width('0%')
                Toast.error(data.error_message);
            }
            addsidebar_btn.attr('disabled', false);
        }
    });

    $('#editsidebar-form').ajaxForm({
        url: Ajaxrequest() + '?t=admin&a=sidebaredit',
        type: 'POST',
        beforeSend: function () {
            form_h = $('.addsidebar-header');
            addsidebar_btn = form_h.find('#addsidebar-btn');
            addsidebar_btn.attr('disabled', true);
        },
        success: function (data) {
            if (data.status == 200) {
                Toast.success(data.success_message);
                location.reload();
            }
            else {
                Toast.error(data.error_message);
            }
            // addtest_btn.attr('disabled', false);
        }
    });

    $('#enableDisableSidebar').click(function (e) {
        e.preventDefault();

        $.ajax({
            url: Ajaxrequest() + '?t=admin&a=sidebarenabledisable',
            type: 'POST',
            success: function (data) {
                if (typeof data.success_message !== 'undefined' && data.success_message) {
                    window.location.reload()
                }

                if (typeof data.error_message !== 'undefined') {
                    Toast.error(data.error_message);
                }
            },
            error: function () {
                Toast.error('Undefined error.');
            }
        });
    });


    $(document).ready(function () {
        $(document).on('click', '#mc-sidebar-delete', function () {
            var _mc_eXcid = $(this).attr('data-sidebar');
            __dltCtgr7(_mc_eXcid);
        });

        function __dltCtgr7(cid) {
            $.ajax({
                url: Ajaxrequest() + '?t=admin&a=sidebarsdelete',
                type: 'POST',
                data: "cid=" + cid,
                success: function () {
                    var _cdlt3 = $('.__mc-' + cid);
                    _cdlt3.slideToggle(200, function () {
                        $(this).remove();
                    });
                }
            });
        }
    });

    /*******************\
       MANAGE FEED DATA  
    \*******************/

    $(document).ready(function () {

        $('#install-games-catalog').on('click', function () {
            var self = $(this);

            install_games_catalog(1);
        });

        function install_games_catalog(page) {
            $.ajax({
                url: Ajaxrequest() + '?t=admin&a=install-games-catalog&page=' + page,
                type: 'POST',
                success: function (data) {
                    if (typeof data.next_page !== 'undefined') {
                        install_games_catalog(data.next_page)
                        $('#install-games-catalog').attr('disabled', true);
                        $('#install-games').attr('disabled', true);
                        $('.installing-message').html('<div class="installing-games-alert">' + data.games_procesing_message + '</div>');
                    } else {
                        if (typeof data.reload_success !== 'undefined' && data.reload_success) {
                            window.location.reload()
                        }

                        if (typeof data.error_message !== 'undefined') {
                            Toast.error(data.error_message);
                        }

                        $('#install-games-catalog').attr('disabled', false);
                        $('#install-games').attr('disabled', false);
                        $('.installing-message').html('');
                    }
                },
                error: function () {
                    $('#install-games-catalog').attr('disabled', false);
                    $('#install-games').attr('disabled', false);
                    $('.installing-message').html('Conection fail!');
                }
            });
        }

        $('#install-games').on('click', function () {
            var self = $(this);

            $.ajax({
                url: Ajaxrequest() + '?t=admin&a=install-games',
                type: 'POST',
                beforeSend: function () {
                    $('#install-games').attr('disabled', true);
                    $('#install-games-download').attr('disabled', true);
                    $('#install-games-catalog').attr('disabled', true);
                    Toast.info('Loading games, please wait...', '', {
                        displayDuration: 0
                    });
                },
                success: function (data) {
                    if (typeof data.message !== 'undefined') {
                        $('#install-games').attr('disabled', false);
                        $('#install-games-download').attr('disabled', false);
                        $('#install-games-catalog').attr('disabled', false);
                        Toast.success(data.message, '', {
                            displayDuration: 5000
                        });
                    } else {
                        if (typeof data.error_message !== 'undefined') {
                            Toast.error(data.error_message);
                        }

                        $('#install-games').attr('disabled', false);
                        $('#install-games-download').attr('disabled', false);
                        $('#install-games-catalog').attr('disabled', false);
                        $('.installing-message').html('');
                    }
                },
                error: function () {
                    $('#install-games').attr('disabled', false);
                    $('#install-games-download').attr('disabled', false);
                    $('#install-games-catalog').attr('disabled', false);
                    $('.installing-message').html('Conection fail!');
                }
            });
        });

        $('#install-games-download').on('click', function () {
            var self = $(this);

            $.ajax({
                url: Ajaxrequest() + '?t=admin&a=install-games-download',
                type: 'POST',
                beforeSend: function () {
                    $('#install-games').attr('disabled', true);
                    $('#install-games-download').attr('disabled', true);
                    $('#install-games-catalog').attr('disabled', true);
                    Toast.info('Loading games, please wait...', '', {
                        displayDuration: 0
                    });
                },
                success: function (data) {
                    if (typeof data.message !== 'undefined') {
                        $('#install-games').attr('disabled', false);
                        $('#install-games-download').attr('disabled', false);
                        $('#install-games-catalog').attr('disabled', false);
                        Toast.success(data.message, '', {
                            displayDuration: 5000
                        });
                    } else {
                        if (typeof data.error_message !== 'undefined') {
                            Toast.error(data.error_message);
                        }

                        $('#install-games').attr('disabled', false);
                        $('#install-games-download').attr('disabled', false);
                        $('#install-games-catalog').attr('disabled', false);
                        $('.installing-message').html('');
                    }
                },
                error: function () {
                    $('#install-games').attr('disabled', false);
                    $('#install-games-download').attr('disabled', false);
                    $('#install-games-catalog').attr('disabled', false);
                    $('.installing-message').html('Conection fail!');
                }
            });
        });

        // PUBLISH ALL GAMES
        $(document).on('click', '#publish-all-games', function () {
            var btn_Sts_dsd = $(this);
            __pblAllGames(btn_Sts_dsd);
        });

        function __pblAllGames($btnSts) {
            $.ajax({
                url: Ajaxrequest() + '?t=admin&a=publish_all_games',
                type: 'POST',
                beforeSend: function () {
                    $btnSts.attr('disabled', true);
                },
                success: function (data) {
                    $btnSts.attr('disabled', false);
                    if (data.status == 200) {
                        Toast.success(data.success_message);
                    }
                },
                error: function () {
                    $btnSts.attr('disabled', false);
                    console.log('Connection failed!');
                }
            });
        }

        $('#install-games-100').on('click', function () {
            var self = $(this);

            $.ajax({
                url: Ajaxrequest() + '?t=admin&a=install-games-100',
                type: 'POST',
                beforeSend: function () {
                    $('#install-games-100').attr('disabled', true);
                    $('#install-games-download').attr('disabled', true);
                    $('#install-games-catalog').attr('disabled', true);
                    Toast.info('Loading games, please wait...', '', {
                        displayDuration: 0
                    });
                },
                success: function (data) {
                    if (typeof data.message !== 'undefined') {
                        $('#install-games-100').attr('disabled', false);
                        $('#install-games-download').attr('disabled', false);
                        $('#install-games-catalog').attr('disabled', false);
                        Toast.success(data.message, '', {
                            displayDuration: 5000
                        });
                        location.reload();
                    } else {
                        if (typeof data.error_message !== 'undefined') {
                            Toast.error(data.error_message);
                        }

                        $('#install-games-100').attr('disabled', false);
                        $('#install-games-download').attr('disabled', false);
                        $('#install-games-catalog').attr('disabled', false);
                        $('.installing-message').html('');
                    }
                },
                error: function () {
                    $('#install-games-100').attr('disabled', false);
                    $('#install-games-download').attr('disabled', false);
                    $('#install-games-catalog').attr('disabled', false);
                    $('.installing-message').html('Conection fail!');
                }
            });
        });

        $('#install-games-1000').on('click', function () {
            var self = $(this);

            $.ajax({
                url: Ajaxrequest() + '?t=admin&a=install-games-1000',
                type: 'POST',
                beforeSend: function () {
                    $('#install-games-1000').attr('disabled', true);
                    $('#install-games-download').attr('disabled', true);
                    $('#install-games-catalog').attr('disabled', true);
                    Toast.info('Loading games, please wait...', '', {
                        displayDuration: 0
                    });
                },
                success: function (data) {
                    if (typeof data.message !== 'undefined') {
                        $('#install-games-1000').attr('disabled', false);
                        $('#install-games-download').attr('disabled', false);
                        $('#install-games-catalog').attr('disabled', false);
                        Toast.success(data.message, '', {
                            displayDuration: 5000
                        });
                        location.reload();
                    } else {
                        if (typeof data.error_message !== 'undefined') {
                            Toast.error(data.error_message);
                        }

                        $('#install-games-1000').attr('disabled', false);
                        $('#install-games-download').attr('disabled', false);
                        $('#install-games-catalog').attr('disabled', false);
                        $('.installing-message').html('');
                    }
                },
                error: function () {
                    $('#install-games-1000').attr('disabled', false);
                    $('#install-games-download').attr('disabled', false);
                    $('#install-games-catalog').attr('disabled', false);
                    $('.installing-message').html('Conection fail!');
                }
            });
        });

        $('#install-games-custom').on('click', function () {
            var self = $(this);
            var customValue = $('#install-games-custom-value').val();
            $.ajax({
                url: Ajaxrequest() + '?t=admin&a=install-games-custom',
                data: {
                    customValue: customValue
                },
                type: 'POST',
                beforeSend: function () {
                    $('#install-games-custom-value').attr('disabled', true);
                    $('#install-games-custom').attr('disabled', true);
                    $('#install-games-download').attr('disabled', true);
                    $('#install-games-catalog').attr('disabled', true);
                    Toast.info('Loading games, please wait...', '', {
                        displayDuration: 0
                    });
                },
                success: function (data) {
                    if (typeof data.message !== 'undefined') {
                        $('#install-games-custom-value').attr('disabled', false);
                        $('#install-games-custom').attr('disabled', false);
                        $('#install-games-download').attr('disabled', false);
                        $('#install-games-catalog').attr('disabled', false);
                        Toast.success(data.message, '', {
                            displayDuration: 5000
                        });
                        window.location.reload();
                    } else {
                        if (typeof data.error_message !== 'undefined') {
                            Toast.error(data.error_message);
                        }

                        $('#install-games-custom-value').attr('disabled', false);
                        $('#install-games-custom').attr('disabled', false);
                        $('#install-games-download').attr('disabled', false);
                        $('#install-games-catalog').attr('disabled', false);
                        $('.installing-message').html('');
                    }
                },
                error: function () {
                    $('#install-games-custom-value').attr('disabled', false);
                    $('#install-games-custom').attr('disabled', false);
                    $('#install-games-download').attr('disabled', false);
                    $('#install-games-catalog').attr('disabled', false);
                    $('.installing-message').html('Conection fail!');
                }
            });
        });

        $('#save-custom-feed').on('click', function () {
            var customGameFeed = $('#custom_game_feed_url').val();
            $.ajax({
                url: Ajaxrequest() + '?t=admin&a=update-custom-game-feed',
                data: {
                    customGameFeed: customGameFeed
                },
                type: 'POST',
                beforeSend: function () {
                    $('#save-custom-feed').attr('disabled', true);
                    Toast.info('Saving feed, please wait...', '', {
                        displayDuration: 0
                    });
                },
                success: function (data) {
                    if (typeof data.message !== 'undefined') {
                        Toast.success(data.message, '', {
                            displayDuration: 5000
                        });
                    } else {
                        if (typeof data.error_message !== 'undefined') {
                            Toast.error(data.error_message);
                        }
                    }
                    $('#save-custom-feed').attr('disabled', false);
                },
            });
        });
    });

    $('[data-href]').click(function () {
        // Ambil nilai 'data-href'
        var url = $(this).data('href');

        // Jika nilai url tidak kosong, lakukan navigasi
        if (url) {
            window.location.href = url;
        }
    });
});