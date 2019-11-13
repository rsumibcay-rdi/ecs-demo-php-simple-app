// jQuery( function( $ ) {
//   $( '.js__add_color' ).on( 'click', function() {
//
//     console.log('Color Generator Starting...');
//     console.log('Post ID: ' + $( '#post_ID' ).val());
//     console.log('Color: ' + $(this).data("color"));
//       loading = false;
//
//       if( ! loading ) {
//   			loading = true;
//         var data = {
//           action: 'poxyAddColor-submit',
//           post_id : $( '#post_ID' ).val(),
//           title : $(this).data("title"),
//           color : $(this).data("color"),
//           query: MyAjax.query,
//         };
//         jQuery.post(MyAjax.ajaxurl, data, function(res) {
//           if( res.success) {
//             loading = false;
//             console.log('success');
//
//             // if(res.data == true) {
//             //   document.getElementById('ticket_name').value = 'Adults';
//             //   $( '#ticket_form_save' ).click();
//             //   console.log('Adding Tickets.');
//             // } else {
//             //   console.log('Already has tickets.');
//             // }
//
//             // var event_tickets_table = document.getElementsByClassName('eventtable');
//             // var continuousElements = event_tickets_table.getElementsByClassName('ticket_edit')
//           	// for (var i = 0; i < continuousElements.length; i++) {
//             //   if(this.element.innerText == '') {
//             //     console.log( i + 'No Text');
//             //   }
//           	// }
//
//           } else {
//             console.log('fail');
//           }
//
//         }).fail(function(xhr, textStatus, e) {
//           console.log(xhr.responseText);
//         });
//       }
//     });
// });



$(document).ready(function () {
  (function ($) {
    var page_template_element = document.getElementById("page_template");
    if(page_template_element) {
      var page_template = page_template_element.options[page_template_element.selectedIndex].value;

      console.log(page_template);
      if(page_template == 'views/template__cybergrx.php' || page_template == 'views/template__landing_page.php' || page_template == 'views/template__vue.php') {

        var old_builder = document.querySelectorAll("[id^='acf-group_'].postbox");
        if(old_builder) {
          for (var i = 0, len = old_builder.length; i < len; i++) {
            old_builder[i].style.visibility = "hidden";
          }
        }

        // var mainContentEditor = document.getElementById("wp-content-wrap");
        // mainContentEditor.style.visibility = "hidden";

        function _closeMetaboxes(elements) {
      		for (var i = 0; i < elements.length; i++) {
            elements[i].parentElement.classList.add('closed');
            elements[i].parentElement.style.backgroundColor = "";
            // if(elements[i] != current) {
        		// 	elements[i].parentElement.classList.add('closed');
        		// 	//elements[i].parentElement.classList.remove('active');
            //   console.log(i);
            // } else {
            //   // current.parentElement.classList.remove('closed');
            //   // console.log(current);
            //   // console.log(elements[i]);
            // }
      		}
        }


        var builder_section_metabox_array = document.querySelectorAll("[id^='poxy_meta___section__'].postbox");
        var builder_section_metabox_array_h2 = document.querySelectorAll("[id^='poxy_meta___section__'].postbox > h2.hndle");
        // console.log(remove_buttons);
    		for (var i = 0, len = builder_section_metabox_array_h2.length; i < len; i++) {
    			builder_section_metabox_array_h2[i].onclick = function (e) {
            // this.parentElement.classList.remove('closed');
            _closeMetaboxes(builder_section_metabox_array_h2);

            // setTimeout(function(){
            //   this.parentElement.classList.remove('closed');
            //   this.parentElement.style.backgroundColor = "gray";
            // }, 500);


            // console.log(this.parentElement);
          }
        }

        var builder_section_array = document.querySelectorAll("#builder-sections select[id^='_poxy__builder__sections__group']");
        // console.log(builder_section_array);
        var component_name_array = [];
    		for (var i = 0, len = builder_section_array.length; i < len; i++) {
          var e = builder_section_array[i];
          component_name_array.push(e.options[e.selectedIndex].value);
        }
        // console.log(component_name_array);

        var builder_section_hash_array = document.querySelectorAll("#builder-sections [id*='_builder__sections__group__section__id']");
        var component_hash_array = [];
    		for (var i = 0, len = builder_section_hash_array.length; i < len; i++) {
          var e = builder_section_hash_array[i];
          component_hash_array.push(e.value);
        }
        // console.log(component_hash_array);

        metabox_order_array = [];
        for (var i = 0, len = component_name_array.length; i < len; i++) {
          metabox_id = '#poxy_meta___' + component_name_array[i] + '__' + component_hash_array[i];
          metabox_order_array.push(metabox_id);
        }

        console.log(metabox_order_array);

        $("#after_editor-sortables").append('<div id="container_div" style="background:#fff;" class="postbox meta-box-sortables ui-sortable"><div class="handlediv" title="Click to toggle."><br></div><h3 class="hndle"><span>Page Content</span></h3><div id="container_inside" class="inside"></div></div>');
        for (var i = 0, len = metabox_order_array.length; i < len; i++) {
          $(metabox_order_array[i]).appendTo("#container_inside");
        }

        // $("#poxy_meta___section__sherbow__hero").appendTo("#container_inside");
        // $("#poxy_meta___section__cybergrx__content").appendTo("#container_inside");

        // console.log('admin js');
        // builder-sections

        // _poxy__builder__sections__group__poxy__builder__sections__group__section
        // _poxy__builder__sections__group_1__poxy__builder__sections__group__section
        // _poxy__builder__sections__group_1__poxy__builder__sections__group__section.parent

        // var container = $("#_poxy__builder__sections__group_1__poxy__builder__sections__group__section");
        // var container = document.getElementById("_poxy__builder__sections__group_1__poxy__builder__sections__group__section").parentNode.parentNode.parentNode.parentNode;
        // var metaNode = document.getElementById("poxy_meta___section__cybergrx__content2");

        // var div = document.createElement('div');
        // div.setAttribute('class', 'rwmb-row');
        // div.appendChild(metaNode);
        // container.parentNode.insertBefore(div, container.nextSibling);

        // container.appendChild('<div class="rwmb-row">' + metaNode + '</div>');
        // $("#poxy_meta___section__cybergrx2__content").appendTo("#builder-sections");
        // console.log(container);

        function _removeClasses(elements) {
      		for (var i = 0; i < elements.length; i++) {
      			elements[i].classList.remove('active')
      			elements[i].parentElement.classList.remove('active');
      		}
      	}

        var remove_buttons = document.querySelectorAll("#builder-sections .remove-clone");
        // console.log(remove_buttons);
    		for (var i = 0, len = remove_buttons.length; i < len; i++) {
    			remove_buttons[i].onclick = function () {
            console.log(this);
          }
        }

        function makeid(length) {
           var result           = '';
           // var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
           var characters       = 'abcdefghijklmnopqrstuvwxyz0123456789';
           var charactersLength = characters.length;
           for ( var i = 0; i < length; i++ ) {
              result += characters.charAt(Math.floor(Math.random() * charactersLength));
           }
           return result;
        }

        function add_section_hash_value($isClone = false) {
          var section_id_inputs = document.querySelectorAll("#builder-sections [id*='_poxy__builder__sections__group__section__id']");
          // console.log(section_id_inputs);





          // if($isClone) {
          //   console.log('__IS_CLONE__');
          //   var last_element = section_id_inputs[section_id_inputs.length - 2];
          //   var last_element_value = last_element.getAttribute("value");
          // } else {
          //   console.log('__NOT_CLONE__');
          //   var last_element = section_id_inputs[section_id_inputs.length - 1];
          //   var last_element_value = last_element.getAttribute("value");
          // }
          //
          // console.log('Last Element: ' + last_element_value);

          console.log('SECTION VALUE ARRAY:');

          for (var i = 0, len = section_id_inputs.length; i < len; i++) {

            if(section_id_inputs[i].value == '') {
              console.log(section_id_inputs[i]);
              section_id_inputs[i].value = makeid(6);
            }

            // var section_id_value = section_id_inputs[i].getAttribute("value");
            //
            //
            // console.log(section_id_value);
            //
            // if($isClone) {
            //   if(section_id_inputs[i] != last_element) {
            //     if( section_id_value == '' || section_id_value == last_element_value ) {
            //       console.log('APPLY NEW ID: ');
            //       console.log(section_id_inputs[i]);
            //       // section_id_inputs[i].value = makeid(6);
            //       var new_id = makeid(6);
            //       section_id_inputs[i].setAttribute('value', new_id);
            //       console.log('New ID: ' + new_id);
            //     }
            //   }
            // } else {
            //   if( section_id_value == '' || section_id_value == null) {
            //     console.log('APPLY NEW ID: ');
            //     console.log(section_id_inputs[i]);
            //     // section_id_inputs[i].value = makeid(6);
            //     var new_id = makeid(6);
            //     section_id_inputs[i].setAttribute('value', new_id);
            //     console.log('New ID: ' + new_id);
            //   }
            // }

          }
        }

        add_section_hash_value();

        var add_section_button = document.querySelectorAll("#builder-sections a.add-clone");
        add_section_button[0].onclick = function () {
          console.log('Add Section');
          setTimeout(function(){
            add_section_hash_value(true);
          }, 100);
        }



        // VISIBLY HIDE ID INPUTS
        var section_id_inputs = document.querySelectorAll("#builder-sections [id*='_poxy__builder__sections__group__section__id']");
        for (var i = 0, len = section_id_inputs.length; i < len; i++) {
          section_id_inputs[i].parentNode.parentNode.parentNode.style.visibility = "hidden";
          
        }

      }
    }
  })(jQuery);
});
