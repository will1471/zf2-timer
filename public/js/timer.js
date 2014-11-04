

var Timer = Backbone.Model.extend({
    url: '/timer',
    rpc: function(method) {
        var that = this;
        $.ajax({
            type: 'POST',
            contentType: 'application/json',
            url: '/timer-rpc/' + this.get('id'),
            data: JSON.stringify({"method": method}),
            complete: function (jqXHR, textStatus ) {
                timers.fetch();
            }
        });
    },
    start: function() {
        this.rpc('start');
    },
    stop: function() {
        this.rpc('stop');
    },
    pause: function() {
        this.rpc('pause');
    },
    resume: function() {
        this.rpc('resume');
    },
    elapsed: function() {
        // this logic is duplicated from PHP, it saves losts of requests though.

        var events = this.get('events');
        if (! events) {
            return 0;
        }

        var elapsed = 0;
        var last = null;

        for (var i = 0; i < events.length; i++) {
            var event = events[i];
            var eventTimestamp = Date.parse(event['datetime']['date']);
            if (! last) {
                last = eventTimestamp;
                continue;
            }

            elapsed = elapsed + ((eventTimestamp - last) / 1000);
            last = null;
        }

        if (last) {
            var now = new Date();
            elapsed = elapsed + ((now.getTime() - last) / 1000);
        }

        return parseInt(elapsed);
    },
    state: function() {
        var events = this.get('events');
        if (! events || events.length === 0) {
            return 'initial';
        }
        switch (events[events.length - 1]['type']) {
            case 'stop':
                return 'stopped';
            case 'pause':
                return 'paused';
            case 'start':
            case 'resume':
                return 'running';
        }
    }
});

var TimerCollection = Backbone.Collection.extend({
    model: Timer,
    url: '/timer',
    parse: function(response) {
        this._links = response['_links'];
        return response['_embedded']['timer'];
    },
    loadMore: function() {
        if (this._links['self']['href'] === this._links['last']['href']) {
            return;
        }
        this.url = this._links['next']['href'];
        this.fetch({'update': true, 'remove': false});
    },
    totalElapsed: function() {
        var sum = 0;
        this.each(function(timer) {
            sum += timer.elapsed();
        });
        return sum;
    }
});

var TimerListItemView = Backbone.View.extend({
    tagName: 'li',
    events: {
        "click .start": "onStart",
        "click .stop": "onStop",
        "click .pause": "onPause",
        "click .resume": "onResume"
    },
    initialize: function() {
        this.listenTo(this.model, "change", this.render);
        this.listenTo(this.model, "sync", this.render);
    },
    render: function() {
        this.$el.append($('<span/>').text(this.model.get('name')).addClass('name'));

        this.time = $('<span/>').addClass('time');
        this.$el.append(this.time);

        this.$el.append($('<a/>').text('start').addClass('start'));
        this.$el.append($('<a/>').text('pause').addClass('pause'));
        this.$el.append($('<a/>').text('resume').addClass('resume'));
        this.$el.append($('<a/>').text('stop').addClass('stop'));

        setInterval(function() {
            this.updateInfo();
        }.bind(this), 1000);

        this.updateInfo();

        return this;
    },
    updateInfo: function() {
        this.time.text(this.model.elapsed() + ' seconds');

        this.$el.removeClass('initial');
        this.$el.removeClass('stopped');
        this.$el.removeClass('running');
        this.$el.removeClass('paused');
        this.$el.addClass(this.model.state());
    },
    onStart: function() {
        this.model.start();
    },
    onStop: function() {
        this.model.stop();
    },
    onPause: function() {
        this.model.pause();
    },
    onResume: function() {
        this.model.resume();
    }
});


var TimerListView = Backbone.View.extend({
    tagName: 'ul',

    initialize: function() {
        this.listenTo(this.collection, "change", this.render);
        this.listenTo(this.collection, "sync", this.render);
    },

    render: function() {
        this.$el.html('');
        this.collection.each(this.addListItem, this);
        this.total = $('<span/>').addClass('total');
        this.$el.append(this.total);
        setInterval(function() {
            this.updateInfo();
        }.bind(this), 1000);
    },

    updateInfo: function() {
        this.total.text(this.collection.totalElapsed() + ' seconds');
    },

    addListItem: function(model) {
        var view = new TimerListItemView({'model': model});
        this.$el.append(view.render().el);
    }

});


var timers = new TimerCollection();
var timersView = new TimerListView({el: $('#timers'), collection: timers});
timers.fetch();

$('#create-timer button').click(function() {
    var timer = new Timer({'name': $(this).parent().find('input[name=name]').val()});
    timer.save(null, {
        'error': function() {
            alert('Error creating timer.');
            //window.location.reload();
        },
        'success': function(model) {
            // reload the timers so the new on has its ID for RCP calls
            timers.fetch();
        }
    });
});
