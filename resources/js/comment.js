//Comment
if (document.getElementById('cancel-comment')) {
    document.getElementById('cancel-comment').addEventListener('click', function (e) {
        var comment = document.getElementById('comment');
        comment.value = null;
    });
}

if (document.getElementById('submit-comment')) {
    document.getElementById('submit-comment').addEventListener('click', function (e) {
        var comment = document.getElementById('comment');
        var formData = new FormData();
        formData.append("comment", comment.value);
        var ajax = new XMLHttpRequest();
        var token = document.getElementsByName('csrf-token')[0].content;
        ajax.open("POST", "/member/comment/" + video_slug);
        ajax.setRequestHeader("X-CSRF-Token", token);
        ajax.send(formData);
        ajax.onreadystatechange = function () {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                user = JSON.parse(user);
                var htmlString = '<div class="comment-container"><div class="comment primary"><div class="img"><img src="' + user.avatar + '" alt="avatar"></div><div class="body"><h5>' + user.firstname + ' ' + user.lastname + '</h5><p>' + comment.value + '</p><div style="float: right; padding-right: 2%" class="row"><a class="bt reply-comment" data-reply-to="' + JSON.parse(this.response).id + '" >Reply</a></div></div></div></div>';
                var div = document.createElement('div');
                div.innerHTML = htmlString.trim();
                var after = document.getElementById('input-comment');
                comment.value = null;
                after.parentNode.insertBefore(div, after.nextSibling);
            }
        };
    });
}

// Reply

document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('reply-comment')) {
        if (user.constructor !== ({}).constructor) {
            user = JSON.parse(user);
        }
        if (document.getElementById('append-reply')) {
            document.getElementById('append-reply').closest('.body').querySelector('.reply-comment').style.display = 'block';
            document.getElementById('append-reply').remove();
        }
        var htmlString = '<textarea name="reply" id="reply" class="form-control" placeholder="Add comment.." style="width: 100%" rows="3"></textarea><div style="float: right; padding-right: 2%" class="row"><a class="bt bt-grey" href="#" id="cancel-reply" >Cancel</a><a class="bt bt-disciple" style="cursor: pointer" id="submit-reply" >Comment</a></div>';
        var div = document.createElement('div');
        div.id = 'append-reply'
        div.innerHTML = htmlString.trim();
        e.target.closest('.body').appendChild(div);
        e.target.style.display = 'none';
    }
});

document.addEventListener('click', function (e) {
    if (e.target && e.target.id === 'cancel-reply') {
        var reply = document.getElementById('reply');
        reply.value = null;
        document.getElementById('append-reply').closest('.body').querySelector('.reply-comment').style.display = 'block';
        document.getElementById('append-reply').remove();
    };
});



document.addEventListener('click', function (e) {
    if (e.target && e.target.id === 'submit-reply') {
        var reply = document.getElementById('reply');
        var reply_link = e.target.closest('.body').querySelector('.reply-comment');
        let parent_id = reply_link.getAttribute('data-reply-to');
        var formData = new FormData();
        formData.append("comment", reply.value);
        formData.append("parent_id", parent_id);
        var ajax = new XMLHttpRequest();
        var token = document.getElementsByName('csrf-token')[0].content;
        ajax.open("POST", "/member/comment/" + video_slug);
        ajax.setRequestHeader("X-CSRF-Token", token);
        ajax.send(formData);
        ajax.onreadystatechange = function () {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                var toggle = '<i class="uil uil-angle-down"></i>Hide replies';
                var div = document.createElement('div');
                div.className = 'toggle-replies';
                div.innerHTML = toggle.trim();
                if (e.target.closest('.body').querySelector('.toggle-replies')) {
                    console.log('found');
                } else {
                    e.target.closest('.body').appendChild(div);
                }
                if (user.constructor !== ({}).constructor) {
                    user = JSON.parse(user);
                }

                var reply_inner = '<div class="img"><img src="' + user.avatar + '" alt="avatar"></div><div class="body"><h5>' + user.firstname + ' ' + user.lastname + '</h5><p>' + reply.value + '</p></div>';
                var reply_el = document.createElement('div');
                reply_el.classList.add('comment');
                reply_el.innerHTML = reply_inner.trim();
                if (e.target.closest('.comment-container').querySelector('.replies')) {
                    var replies = e.target.closest('.comment-container').querySelector('.replies');
                    replies.classList.toggle('collapsed');
                    e.target.closest('.comment-container').querySelector('.replies').appendChild(reply_el);
                } else {
                    var replies = document.createElement('div');
                    replies.classList.add('replies', 'collapsible');
                    replies.appendChild(reply_el);
                    e.target.closest('.comment-container').appendChild(replies);

                }
                document.getElementById('append-reply').closest('.body').querySelector('.reply-comment').style.display = 'block';
                document.getElementById('append-reply').remove();
            }
        };
    };
});