(function ($) {
    $(document).ready(function () {
        $('.leftcontent').delegate('.playlist_item','click',function () {
            $(this).toggleClass('selected');
        });
        $('.rightcontent .mp-listed').delegate('.playlist_item','click',function () {
            $(this).toggleClass('selected');
        });
        $('#send_data').click(function () {
            $('.leftcontent .mp-list li.selected').appendTo('.mp-listed');
            $('.rightcontent .mp-listed li.selected').removeClass('selected');
        });
        $('#clear_data').click(function () {
            $('.rightcontent .mp-listed li.selected').appendTo('.mp-list');
            $('.leftcontent .mp-list li.selected').removeClass('selected');
        });

        $('#clear_all').click(function () {
            $('.rightcontent .mp-listed li').appendTo('.mp-list');
            $('.leftcontent .mp-list li.selected').removeClass('selected');
        });

        $('.clear_nofication').click(function () {
            $('.nofication__item').hide();
        });
        // Nofication process
        var nofication_songnull = $(".nofication__songisnull");
        var nofication_added = $(".nofication__added");
        nofication_added.hide();
        nofication_songnull.hide();
        $('.music-press-quick-playlist-wrap #msqp-publishing-action #publish').click(function () {
            var playlist_title = $("#playlist_title").val();
            var eduarray = {};
            eduarray = [];
            $('#list-added').find('li').each(function () {
                eduarray.push($(this).attr('data-id'));
            });
            if (playlist_title != '' && $("#list-added li").length >= 1) {
                $.ajax({
                    type: "POST", //Phương thức truyền post hoặc get
                    // dataType : "json", //Dạng dữ liệu trả về xml, json, script, or html
                    url: MusicPressQuickPlaylist_playlist_init.url, //Đường dẫn chứa hàm xử lý dữ liệu. Mặc định của WP như vậy
                    data: {
                        action: 'MusicPressQuickPlaylist_playlist_init', //Tên action
                        music_press_quick_playlist_title: playlist_title,
                        music_press_quick_playlist_ids: eduarray
                    },
                    context: this,
                    beforeSend: function () {
                        //Làm gì đó trước khi gửi dữ liệu vào xử lý
                    },
                    success: function (response) {
                        //Làm gì đó khi dữ liệu đã được xử lý
                        nofication_added.show();
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        //Làm gì đó khi có lỗi xảy ra
                        console.log('The following error occured: ' + textStatus, errorThrown);
                    }
                });
                return false;
            } else {
                if ($("#playlist_title").val() == '') {
                    $("#playlist_title").addClass('warning');
                }
                if ($("#list-added li").length < 1) {
                    nofication_songnull.show();
                }
            }

        });
        // Filter project
        $('.music-press-quick-playlist-wrap #filter_songs').click(function () {
            var musicpressquickplaylist_ajaxcontent = $('.mp-list'),
                musicpressquickplaylist_ajaxcontent_child = $('.mp-list li'),
                musicpressquickplaylist_filter_genre = $('.music-press-quick-playlist-wrap #filter select#genre').find(":selected").val(),
                musicpressquickplaylist_filter_album = $('.music-press-quick-playlist-wrap #filter select#album').find(":selected").val(),
                musicpressquickplaylist_filter_artist = $('.music-press-quick-playlist-wrap #filter select#artist').find(":selected").val(),
                musicpressquickplaylist_filter_limit = $('#filter_limit').val(),
                musicpressquickplaylist_filter_order = $('select#order').val(),
                musicpressquickplaylist_filter_orderby = $('select#orderby').val();

            $.ajax({
                type: "POST", //Phương thức truyền post hoặc get
                // dataType : "json", //Dạng dữ liệu trả về xml, json, script, or html
                url: MusicPressQuickPlaylist_playlist_init.url, //Đường dẫn chứa hàm xử lý dữ liệu. Mặc định của WP như vậy
                data: {
                    action: 'MusicPressQuickPlaylist_filter', //Tên action
                    filter_genre: musicpressquickplaylist_filter_genre,
                    filter_album: musicpressquickplaylist_filter_album,
                    filter_artist: musicpressquickplaylist_filter_artist,
                    filter_limit: musicpressquickplaylist_filter_limit,
                    filter_order: musicpressquickplaylist_filter_order,
                    filter_orderby: musicpressquickplaylist_filter_orderby
                },
                context: this,
                beforeSend: function () {
                    //Làm gì đó trước khi gửi dữ liệu vào xử lý
                },
                success: function (data) {
                        musicpressquickplaylist_ajaxcontent_child.remove();
                        musicpressquickplaylist_ajaxcontent.append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    //Làm gì đó khi có lỗi xảy ra
                    console.log('The following error occured: ' + textStatus, errorThrown);
                }
            });
            return false;
        });

    //    Delete single playlist
        $('.delete_single_playlist a').click(function () {
            var get_id_delete = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: MusicPressQuickPlaylist_playlist_init.url,
                data: {
                    action: 'music_press_single_delete',
                    id_delete: get_id_delete
                },
                context: this,
                beforeSend: function () {

                },
                success: function (data) {

                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log('The following error occured: ' + textStatus, errorThrown);
                }
            });
            return false;
        });

        //    Delete single playlist
        $('#replace_playlist #publish').click(function () {
            var get_id_replace = $('#replace_playlist').attr('data-replace-id'),
                replace_get_title = $('#playlist_title').val(),
                song_is_null = $('#playlist_title').val(),
            songidsarray = [];
            $('#list-added').find('li').each(function () {
                songidsarray.push($(this).attr('data-id'));
            });
            if(songidsarray != ''){
                $.ajax({
                    type: "POST",
                    url: MusicPressQuickPlaylist_playlist_init.url,
                    data: {
                        action: 'music_press_replace',
                        id_replace: get_id_replace,
                        replace_title: replace_get_title,
                        replace_songids: songidsarray
                    },
                    context: this,
                    beforeSend: function () {

                    },
                    success: function (data) {
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('The following error occured: ' + textStatus, errorThrown);
                    }
                });
            }else{
                nofication_songnull.show();
            }

            return false;
        });

    });
})(jQuery);