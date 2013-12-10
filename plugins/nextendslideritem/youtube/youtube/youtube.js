(function ($, scope, undefined) {

    if(typeof scope.youtubeplayers == "undefined"){
        scope.youtubeplayers = [];
        var tag = document.createElement("script");
        tag.src = "//www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName("script")[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
        scope.onYouTubeIframeAPIReady = function() {
            for(var i = 0; i < scope.youtubeplayers.length; i++){
                ssInitYoutubePlayer(scope.youtubeplayers[i]);
            }
            scope.youtubeplayers = [];
        }
    
        function ssInitYoutubePlayer(arr){
            var node = arr[0], 
                sliderid = arr[1], 
                player = $("#"+node),
                parent = player.closest(".smart-slider-layer");
                
            var vars = {
                enablejsapi: 1,
                origin: window.location.protocol+"//"+window.location.host,
                autoplay: player.data("autoplay"),
                theme: player.data("theme"),
                modestbranding: 1,
                wmode: "opaque",
                rel: player.data("related"),
                vq: player.data("vq")
            };
            if(+(navigator.platform.toUpperCase().indexOf('MAC')>=0 && navigator.userAgent.search("Firefox") > -1))
                vars.html5 = 1;
            var playerobj = new YT.Player(player.attr("id"), {
                videoId: player.data("youtubecode"),
                wmode: 'opaque',
                playerVars: vars,
                events: {
                    onStateChange: function(state){
                        switch(state.data){
                            case YT.PlayerState.PLAYING:
                                $("#"+sliderid).trigger("ssplaystarted");
                                break;
                            //case YT.PlayerState.PAUSED:
                            case YT.PlayerState.ENDED:
                                $("#"+sliderid).trigger("ssplayended");
                                break;
                        }
                    }
                }
            });
            var player = $("#"+node);
            player.css("display", "block").prev().css("display", "none");
            parent.closest(".smart-slider-canvas").on("ssoutanimationstart", function(){
                if(playerobj && playerobj.pauseVideo) playerobj.pauseVideo();
            });
        }
    }
                
    scope.ssCreateYouTubePlayer = function(playerid, sliderid){
        if(typeof(YT) == 'undefined' || typeof(YT.Player) == 'undefined'){
            scope.youtubeplayers.push([playerid, sliderid]);
        }else{
            $(document).ready(function() {
                ssInitYoutubePlayer([playerid, sliderid]);
            });
        }
    }
})(njQuery, window);