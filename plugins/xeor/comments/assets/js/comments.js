+function ($) { "use strict";

    var Comments = function () {
        this.$comments = $('#comments')

        this.init()
        this.initFormEvents()
    }

    Comments.prototype.initFormEvents = function() {
        var self = this
        $(document).on('ajaxSuccess', '#comment-form', function(event, context, data){
            if (context.handler == 'onComment' && !data.X_OCTOBER_ERROR_FIELDS) {
                var $form = $(this),
                    $to = $form.find('input.to'),
                    $edit = $form.find('input.edit'),
                    $newComment = $('#loader .comment').last() // get new comment

                $('#message-wrapper').show()

                // delete new comment
                $('#loader').html('')

                if ($to.val() && !$edit.val()) { // if reply

                    var id = $to.val(),
                        $currentComment = $('#comment-' + id),
                        $nextElement = $currentComment.next(),
                        isIndent = $nextElement.hasClass('indented')

                    if ($nextElement && isIndent) {
                        $nextElement.append($newComment)
                    }
                    else if ($currentComment) {
                        var $newIndent = $('<div />', {
                            "class": 'indented',
                            html: $newComment})
                        $currentComment.after($newIndent)
                    }

                }
                else if (!$to.val() && $edit.val()) { // if update comment

                    var id = $edit.val(),
                        newCommentContent = $newComment.find('.comment-content').html()

                    $('#comment-' + id + ' .comment-content').html(newCommentContent)

                }
                else if (!$to.val() && !$edit.val()) { // if new comment
                    $('#comments').append($newComment)
                    console.log("new comment111111")
                }

                $form[0].reset()

                if(parseInt(self.$comments.data('hide-reply-form')) === 1) {
                    $form.find('.cancel').trigger('click')
                }

                $('.comment-stars-widget').raty('destroy').raty({
                    score: function () {
                        return $(this).data('score');
                    },
                    path: '/plugins/xeor/comments/assets/images',
                    click: function (score, evt) {
                        $(this).request('onVote', {
                            data: {id: $(this).data('id'), value: score, type: $(this).data('type')},
                            success: function(data) {
                                $('.comment-stars-widget[data-id="' + id + '"]').parent().find('.comment-total').text(data['total'])
                            }
                        });
                    }
                })

            }
        })
    }

    Comments.prototype.init = function() {
        var self = this

        // Replace comment form to initial position
        this.$comments.on('click touchstart', 'a.cancel', function(e) {
            e.preventDefault()

            var $btn = $(this)
            var $form = $btn.closest('form')
            if(parseInt(self.$comments.data('hide-main-form')) === 1) {
                $form.slideUp( "slow", function() {
                    $('#comment-form-wrapper').append($form)
                    $form.find('.cancel-reply').hide()
                    $form[0].reset()
                    $form.find('input.to').val('')
                    $form.find('input.edit').val('')
                    $form.find('input.level').val('')
                    $form.slideDown()
                })
            }
            else {
                $form.slideUp( "slow", function() {
                    $form.remove()
                })
            }
            return false
        })

        // Reply to the comment
        this.$comments.on('click touchstart', 'a.reply', function(e) {
            e.preventDefault()

            var $btn = $(this)
            var id = $btn.data('id')
            var level = $btn.data('level')
            var $comment = $('#comment-' + id)
            var $form = $('#comment-form')
            $form[0].reset()
            if(parseInt(self.$comments.data('hide-main-form')) === 1) {
                $form.slideUp( "slow", function() {
                    $comment.find('.comment-actions').eq(0).after($form)
                    $form.find('#to').val(id)
                    $form.find('#edit').val('')
                    $form.find('#level').val(level + 1)
                    $form.find('.cancel-reply').show()
                    $form.slideDown()
                })
            }
            else {
                $form.find('.cancel').trigger('click')
                var $clone = $form.clone(true)
                $clone.css('display', 'none')
                $comment.find('.comment-actions').eq(0).after($clone)
                $clone.find('#to').val(id)
                $clone.find('#edit').val('')
                $clone.find('#level').val(level + 1)
                $clone.find('.cancel-reply').show()
                $clone.slideDown()
            }
            return false
        })

        // Edit the comment
        this.$comments.on('click touchstart', 'a.edit', function(e) {
            e.preventDefault()

            var $btn = $(this)
            $btn.request('onEditComment', {
                data: {id: $btn.data('id')},
                success: function(data){
                    var id = data['id'],
                        content = data['content'],
                        $comment = $('#comment-' + id),
                        $form = $('#comment-form')
                    $form[0].reset()
                    if(parseInt(self.$comments.data('hide-main-form')) === 1) {
                        $form.slideUp( "slow", function() {
                            $comment.find('.comment-actions').eq(0).after($form)
                            $form.find('#edit').val(id)
                            $form.find('#to').val('')
                            $form.find('#level').val('')
                            $form.find('#content').val(content)
                            $form.find('.cancel-reply').show()
                            $form.slideDown()
                        })
                    }
                    else {
                        var $clone = $form.clone(true)
                        $clone.css('display', 'none')
                        $comment.find('.comment-actions').eq(0).after($clone)
                        $clone.find('#edit').val(id)
                        $clone.find('#to').val('')
                        $clone.find('#level').val('')
                        $clone.find('#content').val(content)
                        $clone.find('.cancel-reply').show()
                        $clone.slideDown()
                    }
                }
            })
            return false
        })

        // Delete the comment
        this.$comments.on('click touchstart', 'a.delete', function(e) {
            e.preventDefault()

            var $btn = $(this),
                $comment = $btn.closest('.comment')
            if($comment.has('.comment-form').length) {
                $comment.find('.cancel-reply-link').trigger('click')
            }
            $btn.request('onDeleteComment', {
                data: {id: $btn.data('id')},
                success: function(data){
                    $.each(data, function (index, id) {
                        $('#comment-' + id).slideUp( "slow", function() {
                            $(this).remove()
                        })
                    })
                }
            })
            return false
        })

        self.$comments.on('click touchstart', '.comment-number-widget a', function(e) {
            e.preventDefault()
            var $this = $(this),
                id = $this.parent().data('id'),
                value = $this.data('value'),
                type = self.$comments.data('rate')

            $(this).request('onVote', {
                data: {id: id, value: value, type: type},
                success: function(data) {
                    $('.comment-number-widget[data-id="' + id + '"]').find('.comment-score').text(data['score'])
                }
            });
            return false
        })

        $('.comment-stars-widget').raty({
            score: function () {
                return $(this).data('score');
            },
            path: '/plugins/xeor/comments/assets/images',
            click: function (score, evt) {
                var $this = $(this),
                    id = $this.data('id'),
                    type = self.$comments.data('rate')
                $this.request('onVote', {
                    data: {id: id, value: score, type: type},
                    success: function(data) {
                        $('.comment-stars-widget[data-id="' + id + '"]').parent().find('.comment-total').text(data['total'])
                    }
                });
            }
        });

    }

    $(document).ready(function(){
        if ($.oc === undefined)
            $.oc = {}

        $.oc.comments = new Comments()
    })

}(window.jQuery);