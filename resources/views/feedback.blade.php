<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('assets/home/images/fave.png')}}" />
    <link rel="apple-touch-icon" href="{{ asset('assets/home/images/fave.png')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/owlcarousel/owl.carousel.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/feedback.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/home/css/animate.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/toastr/toastr.min.css')}}" />
    <title>{{ __('teachers.siteTitle') }}</title>

    <script type="text/javascript">
        !function(T,l,y){var S=T.location,k="script",D="instrumentationKey",C="ingestionendpoint",I="disableExceptionTracking",E="ai.device.",b="toLowerCase",w="crossOrigin",N="POST",e="appInsightsSDK",t=y.name||"appInsights";(y.name||T[e])&&(T[e]=t);var n=T[t]||function(d){var g=!1,f=!1,m={initialize:!0,queue:[],sv:"5",version:2,config:d};function v(e,t){var n={},a="Browser";return n[E+"id"]=a[b](),n[E+"type"]=a,n["ai.operation.name"]=S&&S.pathname||"_unknown_",n["ai.internal.sdkVersion"]="javascript:snippet_"+(m.sv||m.version),{time:function(){var e=new Date;function t(e){var t=""+e;return 1===t.length&&(t="0"+t),t}return e.getUTCFullYear()+"-"+t(1+e.getUTCMonth())+"-"+t(e.getUTCDate())+"T"+t(e.getUTCHours())+":"+t(e.getUTCMinutes())+":"+t(e.getUTCSeconds())+"."+((e.getUTCMilliseconds()/1e3).toFixed(3)+"").slice(2,5)+"Z"}(),iKey:e,name:"Microsoft.ApplicationInsights."+e.replace(/-/g,"")+"."+t,sampleRate:100,tags:n,data:{baseData:{ver:2}}}}var h=d.url||y.src;if(h){function a(e){var t,n,a,i,r,o,s,c,u,p,l;g=!0,m.queue=[],f||(f=!0,t=h,s=function(){var e={},t=d.connectionString;if(t)for(var n=t.split(";"),a=0;a<n.length;a++){var i=n[a].split("=");2===i.length&&(e[i[0][b]()]=i[1])}if(!e[C]){var r=e.endpointsuffix,o=r?e.location:null;e[C]="https://"+(o?o+".":"")+"dc."+(r||"services.visualstudio.com")}return e}(),c=s[D]||d[D]||"",u=s[C],p=u?u+"/v2/track":d.endpointUrl,(l=[]).push((n="SDK LOAD Failure: Failed to load Application Insights SDK script (See stack for details)",a=t,i=p,(o=(r=v(c,"Exception")).data).baseType="ExceptionData",o.baseData.exceptions=[{typeName:"SDKLoadFailed",message:n.replace(/\./g,"-"),hasFullStack:!1,stack:n+"\nSnippet failed to load ["+a+"] -- Telemetry is disabled\nHelp Link: https://go.microsoft.com/fwlink/?linkid=2128109\nHost: "+(S&&S.pathname||"_unknown_")+"\nEndpoint: "+i,parsedStack:[]}],r)),l.push(function(e,t,n,a){var i=v(c,"Message"),r=i.data;r.baseType="MessageData";var o=r.baseData;return o.message='AI (Internal): 99 message:"'+("SDK LOAD Failure: Failed to load Application Insights SDK script (See stack for details) ("+n+")").replace(/\"/g,"")+'"',o.properties={endpoint:a},i}(0,0,t,p)),function(e,t){if(JSON){var n=T.fetch;if(n&&!y.useXhr)n(t,{method:N,body:JSON.stringify(e),mode:"cors"});else if(XMLHttpRequest){var a=new XMLHttpRequest;a.open(N,t),a.setRequestHeader("Content-type","application/json"),a.send(JSON.stringify(e))}}}(l,p))}function i(e,t){f||setTimeout(function(){!t&&m.core||a()},500)}var e=function(){var n=l.createElement(k);n.src=h;var e=y[w];return!e&&""!==e||"undefined"==n[w]||(n[w]=e),n.onload=i,n.onerror=a,n.onreadystatechange=function(e,t){"loaded"!==n.readyState&&"complete"!==n.readyState||i(0,t)},n}();y.ld<0?l.getElementsByTagName("head")[0].appendChild(e):setTimeout(function(){l.getElementsByTagName(k)[0].parentNode.appendChild(e)},y.ld||0)}try{m.cookie=l.cookie}catch(p){}function t(e){for(;e.length;)!function(t){m[t]=function(){var e=arguments;g||m.queue.push(function(){m[t].apply(m,e)})}}(e.pop())}var n="track",r="TrackPage",o="TrackEvent";t([n+"Event",n+"PageView",n+"Exception",n+"Trace",n+"DependencyData",n+"Metric",n+"PageViewPerformance","start"+r,"stop"+r,"start"+o,"stop"+o,"addTelemetryInitializer","setAuthenticatedUserContext","clearAuthenticatedUserContext","flush"]),m.SeverityLevel={Verbose:0,Information:1,Warning:2,Error:3,Critical:4};var s=(d.extensionConfig||{}).ApplicationInsightsAnalytics||{};if(!0!==d[I]&&!0!==s[I]){var c="onerror";t(["_"+c]);var u=T[c];T[c]=function(e,t,n,a,i){var r=u&&u(e,t,n,a,i);return!0!==r&&m["_"+c]({message:e,url:t,lineNumber:n,columnNumber:a,error:i}),r},d.autoExceptionInstrumented=!0}return m}(y.cfg);function a(){y.onInit&&y.onInit(n)}(T[t]=n).queue&&0===n.queue.length?(n.queue.push(a),n.trackPageView({})):a()}(window,document,{
        src: "https://js.monitor.azure.com/scripts/b/ai.2.min.js", // The SDK URL Source
        // name: "appInsights", // Global SDK Instance name defaults to "appInsights" when not supplied
        // ld: 0, // Defines the load delay (in ms) before attempting to load the sdk. -1 = block page load and add to head. (default) = 0ms load after timeout,
        // useXhr: 1, // Use XHR instead of fetch to report failures (if available),
        crossOrigin: "anonymous", // When supplied this will add the provided value as the cross origin attribute on the script tag
        // onInit: null, // Once the application insights instance has loaded and initialized this callback function will be called with 1 argument -- the sdk instance (DO NOT ADD anything to the sdk.queue -- As they won't get called)
        cfg: { // Application Insights Configuration
            instrumentationKey: "{{ config('constants.instrumentKey') }}"
            /* ...Other Configuration Options... */
        }});
    </script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('constants.feedbackGtag') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', "{{ config('constants.feedbackGtag') }}");
    </script>
</head>
<body>
    <div id="loader-wrapper">
        <div id="loader1">
            <img src="{{ asset('assets/home/images/logo.png') }}" alt="">
        </div>
    </div>
    <header class="sticky">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-4 col-4">
                    <a href="/">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="461.5px" height="227.5px" viewBox="0 0 461.5 227.5" enable-background="new 0 0 461.5 227.5" xml:space="preserve">
                            <g>
                                <path id="XMLID_10_" fill="" d="M368.053,166.368c0,0,31.207,2.057,34.293,5.144s5.83,34.294,5.83,34.294
                                    c0,1.371,0.344,2.4,0.686,2.4c0.344,0,1.029-1.029,1.029-2.4c0,0,2.057-31.207,5.145-34.294c3.086-3.087,34.293-5.83,34.293-5.83
                                    c1.371,0,2.4-1.028,2.4-1.028c0-0.344-1.029-0.686-2.4-0.686c0,0-31.207-2.059-34.293-5.145c-3.088-3.086-5.83-34.293-5.83-34.293
                                    c0-1.372-0.344-2.401-0.686-2.401c-0.344,0-1.029,1.029-1.029,2.401c0,0-2.059,31.207-5.145,34.293s-34.293,5.83-34.293,5.83
                                    c-1.371,0-2.4,0.343-2.4,0.686S366.682,166.368,368.053,166.368z"/>
                                <path id="XMLID_7_" fill="" d="M327.586,95.037c0,0,19.205,1.372,20.92,3.086c2.057,2.058,3.43,20.919,3.43,20.919
                                    c0,0.686,0.342,1.372,0.342,1.372s0.686-0.687,0.686-1.372c0,0,1.373-19.205,3.088-20.919c2.057-2.058,20.918-3.43,20.918-3.43
                                    c0.686,0,1.371-0.686,1.371-0.686s-0.686-0.343-1.371-0.343c0,0-19.203-1.372-20.918-3.086c-2.059-2.058-3.43-20.919-3.43-20.919
                                    c0-0.686-0.344-1.372-0.344-1.372s-0.686,0.686-0.686,1.372c0,0-1.371,19.205-3.086,20.919c-2.059,2.058-20.92,3.43-20.92,3.43
                                    c-0.686,0-1.371,0.343-1.371,0.343C325.871,94.694,326.559,95.037,327.586,95.037z"/>
                                <g>
                                    <path fill="" d="M186.641,59.715c2.058,1.372,5.144,3.429,8.23,5.487c21.948,15.089,43.895,30.178,65.844,45.267
                                        c27.777,18.862,55.898,37.723,83.676,56.927c1.371,1.028,3.086,2.058,4.115,3.429c1.029,2.059,0.686,4.459-1.373,5.83
                                        c-2.057,1.715-4.113,1.372-6.172,0c-21.262-14.402-42.523-28.807-63.443-43.209c-23.662-16.118-47.667-32.236-71.33-48.354
                                        c-8.23-5.487-16.118-10.974-24.005-16.461c-2.4-1.714-2.744-3.772-2.058-6.173C180.811,59.372,182.869,58.343,186.641,59.715z"/>
                                    <path fill="" d="M107.766,25.421c-8.573-3.429-15.775-3.086-21.948,0.343C93.02,24.735,100.222,24.735,107.766,25.421
                                        L107.766,25.421z M42.952,86.463c-3.429,4.458-6.859,8.574-10.631,11.66c27.092,39.438,54.184,79.217,81.275,118.654
                                        c22.977-18.518,49.725-82.646,73.388-73.73c-24.349-10.631-68.93-2.057-94.993,15.09L42.952,86.463z"/>
                                    <path fill="" d="M107.766,25.421c-13.717-5.83-26.063-3.086-37.723,3.772C81.36,25.764,94.049,24.05,107.766,25.421
                                        L107.766,25.421z M28.891,65.544c-7.201,6.859-14.06,13.375-21.604,18.519c27.092,39.78,54.184,79.218,81.275,118.655
                                        c25.72-17.147,72.016-69.958,98.079-60.356c-24.348-10.288-68.93-1.715-94.649,15.089L28.891,65.544z"/>
                                    <path fill="" d="M107.766,25.421C70.043,14.791,42.609,33.309,9.344,56.286c27.092,39.437,54.184,79.217,81.618,118.654
                                        c24.005-15.774,64.128-40.123,90.534-33.949c-25.034-7.202-65.157,1.371-89.163,17.146
                                        C68.329,123.158,45.695,90.236,21.347,55.256C36.779,42.911,68.329,21.649,107.766,25.421L107.766,25.421z"/>
                                    
                                        <rect x="121.465" y="11.381" transform="matrix(-0.9678 0.2516 -0.2516 -0.9678 275.3729 17.7294)" fill="" width="30.177" height="30.177"/>
                                    
                                        <rect x="121.522" y="55.618" transform="matrix(-0.9678 0.2519 -0.2519 -0.9678 274.4488 95.3114)" fill="" width="19.205" height="19.205"/>
                                    
                                        <rect x="154.029" y="71.364" transform="matrix(-0.9677 0.252 -0.252 -0.9677 349.235 123.3789)" fill="" width="25.377" height="25.377"/>
                                    
                                        <rect x="170.578" y="29.865" transform="matrix(-0.9678 0.2519 -0.2519 -0.9678 366.0148 33.4545)" fill="" width="20.577" height="20.577"/>
                                    
                                        <rect x="106.394" y="86.855" transform="matrix(-0.9679 0.2514 -0.2514 -0.9679 245.6677 155.3553)" fill="" width="13.032" height="13.032"/>
                                    
                                        <rect x="130.006" y="96.085" transform="matrix(-0.968 0.2509 -0.2509 -0.968 294.4197 167.666)" fill="" width="13.031" height="13.032"/>
                                    
                                        <rect x="104.972" y="117.038" transform="matrix(-0.9677 0.252 -0.252 -0.9677 244.8009 210.6168)" fill="" width="7.887" height="7.887"/>
                                </g>
                            </g>
                        </svg>
                    </a>
                </div>
                <div class="col-md-9 col-sm-8 col-8">
                    <h2>{{ __('teachers.siteTitle') }}</h2>
                </div>

            </div>
        </div>

    </header>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h4>{{ __('teachers.grading.gradingFeedbackHeading') }}</h4>
                    <p class="mb-1">{{ __('teachers.userFeedback') }}</p>
                    <div class="rating-outer ">
                        <div class="rating-container2 mb-2">
                             <div class="radio_group">
                                <input type="radio" name="stars" value="Like">
                                <label for="stars"><i class="fa fa-thumbs-up"></i> </label>
                            </div>
                            <div class="radio_group">
                                <input type="radio" name="stars" value="Dislike">
                                <label for="stars"><i class="fa fa-thumbs-down"></i></label>
                            </div>  
                        </div>
                        <textarea class="form-control" name="comment" id="" cols="30" rows="4" placeholder="Add a comment (Optional)"></textarea>
                    </div>
                    
                </div>
                <div class="card">
                    <div class="">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="betaChecked" id="customCheck1">
                            <label class="custom-control-label" for="customCheck1">{{ __('teachers.exploreFeedbackText') }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="slide-panel">
        <div class="p-3">
            <i class="fa fa-times-circle close" id="close" aria-hidden="true"></i>
            <p>{{ __('teachers.feedbackFormText') }}</p>
            <div class="form-group mb-1">
                <label for=""><small>{{ __('teachers.feedbackContactText') }} </small></label>
                <input type="number" class="form-control" name="contact_no" placeholder="Enter Contact No.">
            </div>
            <div id="or">{{ __('teachers.orText') }}</div>
            <div class="form-group ">
                <label for=""><small>{{ __('teachers.feedbackEmailText') }} </small></label>
                <input type="text" class="form-control" name="email_id" placeholder="Enter Email id">
            </div>
        </div>
        <button class="btn btn-primary btn-block submitForm">{{ __('teachers.sendFeedbackText') }}</button>
    </div>
    <div class="footer">
        <button class="btn btn-primary btn-block checkFeedback" id="slide-open">{{ __('teachers.sendFeedbackText') }}</button>
    </div>
    <div class="overlay-2"></div>
    <script src="{{ asset('assets/js/jquery-3.2.1.slim.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{ asset('assets/js/utils.js')}}"></script>
    <script>
        let userIp;
        $(document).ready(function(){
            $.ajax({
                type: "GET",
                url: "https://jsonip.com/",
                dataType: "json",
                success: function (response) {
                    userIp = response.ip;
                    hitURL(userIp);
                }
            });

            setTimeout(() => {
                $('#loader-wrapper').fadeOut();
            }, 1500);

        });
        
        $("#slide-open").click(function() {
            if($("input[name=stars]").is(":checked")) {
                $(".slide-panel").addClass("active");
                $(".overlay-2").addClass("d-block");
            } else {
                msgToast('info', "{{ __('teachers.userFeedback') }}");
            }
        });

        $(document).on("click", ".submitForm", function(){
            var contactNo = $("input[name=contact_no]").val();
            var emailId = $("input[name=email_id]").val();
            var starVal = $("input[name=stars]:checked").val();
            var commentText = $("textarea[name=comment]").val();
            var betaChecked = $("input[name=betaChecked]").is(":checked");
            
            var emailPattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i; // Email Regex
            var phonePattern = /^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[789]\d{9}$/i; // Phone Regex
            if(contactNo == "" && emailId == "") {
                msgToast('info', 'Please add Contact no. or Email Id.');
                return false;
            }
            if(contactNo !== "" && !phonePattern.test(contactNo)) {
                msgToast('error', 'Not a valid contact no.');
                return false;
            }

            if(emailId!== "" && !emailPattern.test(emailId)) {
                msgToast('error', 'Not a valid e-mail address');
                return false;
            }
            sendFeedback(contactNo, emailId, starVal, commentText, betaChecked);
        });

        function sendFeedback(contactNo, emailId, starVal, commentText, betaChecked) {
            appInsights.trackEvent({
                name: 'usersFeedback',
                properties: {
                    feedback: {
                        contactNo : contactNo,
                        emailId: emailId,
                        starValue: starVal,
                        comment: commentText,
                        joinBetaProgram: betaChecked,
                        userIP: userIp,
                        datetime: new Date()
                    }
                }
            });

            msgToast('success', "{{ __('teachers.thanksText') }}");
            setTimeout(() => {
                location.href = "{{ route('home_page') }}";
            }, 2000);
        }

        function hitURL(userIp) {
            appInsights.trackEvent({
                name: 'feedbackLand',
                properties: {
                    feedback: {
                        userIP: userIp,
                        datetime: new Date()
                    }
                }
            });
        }

        $(document).on("change, keydown", "input[name=contact_no]", function(e) {
            var dataVal = String.fromCharCode(e.which) || e.key;
            var regExp = /[0-9]/i;
            if (!regExp.test(dataVal)
                && e.which != 188 // ,
                && e.which != 190 // .
                && e.which != 8   // backspace
                && e.which != 46  // delete
                && (e.which < 37  // arrow keys
                    || e.which > 40) && (e.which > 105  // arrow keys
                    || e.which < 96)) {
                    e.preventDefault();
                    return false;
                }
            return true;
        });

        $("#close").click(function() {
            $(".slide-panel").removeClass("active");
            $(".overlay-2").removeClass("d-block");
        });
        $(".overlay-2").click(function() {
            $(".slide-panel").removeClass("active");
            $(".overlay-2").removeClass("d-block");
        });

        const labels = document.querySelectorAll('label');
        const getInput = val => document.getElementById(`star_${val}`);

        labels.forEach(label => {
            label.addEventListener('touchstart', e => {
                const targetInput = getInput(e.target.control.value);
                targetInput.checked = true;
            })

            label.addEventListener('touchmove', e => {
                const touch = e.touches[0]
                const targetLabel = document.elementFromPoint(touch.clientX, touch.clientY)

                if (!targetLabel || !targetLabel.htmlFor) {
                    return
                }

                const targetInput = document.getElementById(targetLabel.htmlFor)
                targetInput.checked = true;
            })
        })
    </script>

</body>

</html>