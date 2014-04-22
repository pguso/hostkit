CKEDITOR.plugins.add( 'pricingtable', {
    requires: 'widget',

    icons: 'pricingtable',

    init: function( editor ) {
		CKEDITOR.dialog.add( 'pricingtable', this.path + 'dialogs/pricingtable.js' );
	
        editor.widgets.add( 'pricingtable', {

            button: 'Create Pricing Table',

            template:
                '<div class="pricingtable">' +
                    '<h2 class="pricingtable-title">Title</h2>' +
                    '<div class="pricingtable-content"><p>Content...</p></div>' +
					'<button>Buy</button>' +
                '</div>',

            editables: {
                title: {
                    selector: '.pricingtable-title',
                    allowedContent: 'br strong em'
                },
                content: {
                    selector: '.pricingtable-content',
                    allowedContent: 'p br ul ol li strong em'
                }
            },

            allowedContent:
                'div(!pricingtable,align-left,align-right,align-center){width};' +
                'div(!pricingtable-content); h2(!pricingtable-title)',

            requiredContent: 'div(pricingtable)',

            dialog: 'pricingtable',

            upcast: function( element ) {
                return element.name == 'div' && element.hasClass( 'pricingtable' );
            },

            init: function() {
                var width = this.element.getStyle( 'width' );
                if ( width )
                    this.setData( 'width', width );
                if ( this.element.hasClass( 'align-left' ) )
                    this.setData( 'align', 'left' );
                if ( this.element.hasClass( 'align-right' ) )
                    this.setData( 'align', 'right' );
                if ( this.element.hasClass( 'align-center' ) )
                    this.setData( 'align', 'center' );
            },

            data: function() {

                if ( this.data.width == '' )
                    this.element.removeStyle( 'width' );
                else
                    this.element.setStyle( 'width', this.data.width );

                this.element.removeClass( 'align-left' );
                this.element.removeClass( 'align-right' );
                this.element.removeClass( 'align-center' );
                if ( this.data.align )
                    this.element.addClass( 'align-' + this.data.align );
            }
        } );
    }
} );