$(document).ready(function() {
    $(document).on('click', '.card-heading .removepanel', function() {
        var $this = $(this);
        $this.parents('.card').hide('slow');
    });
    //panel hide
    $('.showhide').attr('title', 'Hide Panel content');
    $(document).on('click', '.card-heading .clickable', function(e) {
        var $this = $(this);
        if (!$this.hasClass('card-collapsed')) {
            $this
                .parents('.card')
                .find('.card-body')
                .slideUp();
            $this.addClass('card-collapsed');
            $this
                .find('i')
                .removeClass('fa-chevron-up')
                .addClass('fa-chevron-down');
            $('.showhide').attr('title', 'Show Panel content');
        } else {
            $this
                .parents('.card')
                .find('.card-body')
                .slideDown();
            $this.removeClass('card-collapsed');
            $this
                .find('i')
                .removeClass('fa-chevron-down')
                .addClass('fa-chevron-up');
            $('.showhide').attr('title', 'Hide Panel content');
        }
    });
});

// Add the Select All and Deselect all options to the chosen multiselect control
$(".chosen-select.chosen-select-all").each(function(){
    var parentSelect = $(this);

    //check to see if this was already added.
    var selectAllOption = parentSelect.find("option[value='chosen-select-all-option']");
    if(selectAllOption == undefined || selectAllOption.length == 0){
        //Add the options as default first and last for Select and Deselect respectively.
        parentSelect.prepend("<option value='chosen-select-all-option' id='chosen-select-all-option'>-- Select All --</option>");
        parentSelect.append("<option value='chosen-select-none-option' id='chosen-select-none-option'>-- Deselect All --</option>");

        //When it chages loop through the options list to see which were selected.
        parentSelect.change(function() {
            $(this).find("option:selected").each(function(){
                var value = $(this).attr("value");
                switch (value){
                    //If one of the options selected was the 'Select All' option, remove the Select All and Deselect All options, set all other options to selected, add the master Select All and Deselect All back after the fact. Update Chosen
                    case "chosen-select-all-option":
                        parentSelect.find("option[value='chosen-select-all-option']").remove();
                        parentSelect.find("option[value='chosen-select-none-option']").remove();
                        parentSelect.find("option").prop("selected","selected");
                        parentSelect.prepend("<option value='chosen-select-all-option' id='chosen-select-all-option'>-- Select All --</option>");
                        parentSelect.append("<option value='chosen-select-none-option' id='chosen-select-none-option'>-- Deselect All --</option>");
                        parentSelect.trigger("chosen:updated");
                        break;
                    case "chosen-select-none-option":
                        parentSelect.find("option[value='chosen-select-all-option']").remove();
                        parentSelect.find("option[value='chosen-select-none-option']").remove();
                        parentSelect.find("option").prop("selected",false);
                        parentSelect.prepend("<option value='chosen-select-all-option' id='chosen-select-all-option'>-- Select All --</option>");
                        parentSelect.append("<option value='chosen-select-none-option' id='chosen-select-none-option'>-- Deselect All --</option>");
                        parentSelect.trigger("chosen:updated");
                        break;
                }
            });
        }).trigger( "change" );

        //Update chosen to include the Select all and Deselect All options
        parentSelect.trigger("chosen:updated");
    }
});