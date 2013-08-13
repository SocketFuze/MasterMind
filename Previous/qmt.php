<form method="get" action="{{base-url}}" class="taxonomy-drilldown-checkboxes">
    {{#taxonomy}}
    <div id="terms-{{taxonomy}}">
        <h4>{{title}}</h4>
        <ul>
            {{{term-list}}}
        </ul>
    </div>
    {{/taxonomy}}
    <!--
        <p>

            <a href="" id="ajaxVibes">Click Vibes</a>
        </p>
        -->
    <p>
        <input type="submit" value="{{submit-text}}" />
        <a class="taxonomy-drilldown-reset" href="{{reset-url}}">{{reset-text}}</a>
    </p>

</form>

<script type="text/javascript">
    /* var ajaxManager = (function() {
     var requests = [];

     return {
     addReq:  function(opt) {
     requests.push(opt);
     },
     removeReq:  function(opt) {
     if( $.inArray(opt, requests) > -1 )
     requests.splice($.inArray(opt, requests), 1);
     },
     run: function() {
     var self = this,
     orgSuc;

     if( requests.length ) {
     oriSuc = requests[0].complete;

     requests[0].complete = function() {
     if( typeof oriSuc === 'function' ) oriSuc();
     requests.shift();
     self.run.apply(self, []);
     };

     $.ajax(requests[0]);
     } else {
     self.tid = setTimeout(function() {
     self.run.apply(self, []);
     }, 1000);
     }
     },
     stop:  function() {
     requests = [];
     clearTimeout(this.tid);
     }
     };
     }());
     */
    /* <![CDATA[ */
    //$(document).ready(function () {
    //window.addEvent('domready', function(){
    jQuery(document).ready(function($) {

        var form = $('form.taxonomy-drilldown-checkboxes');
        var checkbox = document.id('ajaxVibes');
        var target_el = $('div.component-content');

        $(checkbox).click(function(e) {
            e.stop();
            alert ( 'NIGGAH' );

            target_el.empty().html('<br/><h2>Please wait, loading...</h2>');

            $.ajax({
                data: $(form).serialize(),
                type: $(form).attr('method'),
                url:  $(form).attr('action'),
                success: function(response) {

                    target_el.html($(response));

                }
            });
            return false; // cancel original event to prevent form submitting
        });


        /*
         $('#ajaxVibes').click(function() {
         alert ( 'helllooooooo' );
         });


         var checkbox = document.id('ajaxVibes');
         if (checkbox) {
         checkbox.addEvent('click', function(e) {
         e.stop();
         alert ( 'helllooooooo' );
         });
         }
         */
        /*
         var form = $('form.taxonomy-drilldown-checkboxes');
         //var checkbox = $("input[type='checkbox']"); //$('.ajaxVibes');
         //var checkbox = document.getElementById('ajaxVibes');

         ajaxManager.run();

         //$('#ajaxVibes').on('change', function () {
         checkbox.click(function () {
         alert ( 'helllooooooo' );
         // From the other examples
         if (!this.checked) {
         var sure = confirm("Are you sure?");
         this.checked = sure;
         alert (sure.toString());
         }

         if (!$(this).is(':checked')) {
         this.checked = confirm("Are you sure?");
         $(this).trigger("change");
         }
         e.preventDefault();
         ajaxManager.addReq({
         url: form.attr('action'),
         type: form.attr('method'),
         cache: false,
         data: $(form).serializeArray(),
         success: function (data) {
         alert ( data );
         next();
         }, // success
         failure: function(data){
         next();
         }, // failure
         error: function(data){
         next();
         } // error
         }); // ajax

         }); // on
         */

        /*
         $('term-item').on("click", function (e) {
         var that = $(this),
         url = that.attr('action'),
         type = that.attr('method'),
         data = {};

         that.find('[name]').each(function(index, value) {
         var that = $(this),
         name = that.attr('name'),
         value = that.val();

         data[name] = value;
         });

         $.ajax({
         url: url,
         type: type,
         data: data,
         success: function(response) {
         alert ( data );
         }
         });

         return false;
         });

         */

    }); // ready
    /* ]]> */
</script>