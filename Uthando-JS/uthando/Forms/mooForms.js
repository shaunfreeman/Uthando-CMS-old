/**
* @desc mooForms.js - custom radio and checkboxes for forms.
* @author Shaun Freeman <shaun@shaunfreeman.co.uk>
* @Copyright Shaun Freeman 2007
* @date Wed Oct 24 13:31:24 BST 2007 
* @license      GNU/GPL, see LICENSE.txt
*   This program is free software: you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation, either version 3 of the License, or
*   (at your option) any later version.
*
*   This program is distributed in the hope that it will be useful,
*   but WITHOUT ANY WARRANTY; without even the implied warranty of
*   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*   GNU General Public License for more details.
*
*   You should have received a copy of the GNU General Public License
*   along with this program.  If not, see <http://www.gnu.org/licenses/>.
* @ - Wed Oct 24 13:31:24 BST 2007
*     - 1st release
*
* @version 1.1 - Sat Jan 19 15:31:36 GMT 2008
*     - added labelPosition
*		- put label on left or right
*
* @version 1.2 - Tue 25 Mar 2008 09:56:15 GMT 
*     - updated to work with mootools 1.2b-dev
*     - fixed ie drag 'n' drop so image clears
*
* @version 1.3 - Wed 24 Sept 2008
*     - added support for disabled form elements 
*/

var mooForms = new Class({

    Implements: [Options],

    options: {
			imageDir: './images/',
			checkboxImage: {image: 'checkbox.gif', width: 16, height: 20},
			radioImage: {image: 'radio.gif', width: 16, height: 20},
			spacer: 'spacer.gif',
			inputs: ['checkbox', 'radio'],
			labelPosition: 'right'
    },
    
    initialize: function(element, options){
		
		if(options) this.setOptions(options);
		
        this.el = $(element);
        this.elid = element;
		
		this.options.inputs.each(function (input) {
        	this.build(input);
		}.bind(this));
		
		this.divs = this.el.getElements('div');
		
        this.divs.each(function(item){ 
			if (!item.hasClass('disabled')) { 
				if (item.hasClass('checkbox') || item.hasClass('radio')) {
				
					item.addEvents({
					
						'mousedown': function(event){
							new Event(event).stop();
							this.effect(item);
							return false;
						}.bind(this),
					
	 					'click': function(event){	 
		 					this.handle(item);
						}.bind(this)
					
					});
				
					// ie fix for default drag 'n' drop on image.
					if (Browser.Engine.trident) {
					
						item.getElement('img').ondragend = function(event){
							//window.event.returnValue=false;
							this.clear(item);
							return false;
						}.bind(this);
					
					}
				
					window.addEvent('mouseup', function(event){
						this.clear(item);
					}.bind(this));
				}
			}
			
		}.bind(this));
	},
 
    build: function(input){
    	
		formElement = this.el.getElements('input[type=' + input + ']');
		
        formElement.each(function (inputElement) {
			
			if (input == 'checkbox') {
				this.image = this.options.imageDir + this.options.checkboxImage.image;
				this.imageWidth = this.options.checkboxImage.width;
				this.imageHeight = this.options.checkboxImage.height;
				
			}
			if (input == 'radio') {
				this.image = this.options.imageDir + this.options.radioImage.image;
				this.imageWidth = this.options.radioImage.width;
				this.imageHeight = this.options.radioImage.height;
			}

			this.spacer = new Asset.image(this.options.imageDir + this.options.spacer);
			
			this.spacer.setStyles({
				'width': this.imageWidth,
				'height': this.imageHeight,
				'vertical-align': 'middle',
				'background-image': 'url(' + this.image + ')',
				'background-repeat': 'no-repeat',
				'background-position': '0px 0px'
			});
			
            wrapper = new Element('div', {
                'class': input,
				'styles': {
				 	'cursor': 'default', 
					'display': 'inline'
				}
			});
			
			if (this.options.labelPosition == 'left') {
				label = inputElement.getPrevious();
				wrapper.injectBefore(inputElement).
						adopt(label)
						.adopt(this.spacer)
						.adopt(inputElement); 
			} else {
				label = inputElement.getNext();
				wrapper.injectBefore(inputElement)
						.adopt(this.spacer)
						.adopt(inputElement)
						.adopt(label);
			}
			
			label.setStyles({
				'vertical-align': 'middle',
				'display': 'inline'
			});
			
			inputElement.setStyle('display', 'none');
			
            if (inputElement.getAttribute('checked')) {
                wrapper.addClass('selected');
				this.spacer.setStyle('background-position', '0px -' + (this.imageHeight * 2) + 'px');
			}
			
			if (inputElement.getAttribute('disabled')) {
				wrapper.addClass('disabled');
				if (wrapper.hasClass('selected')) {
					this.spacer.setStyle('background-position', '0px -' + (this.imageHeight * 3) + 'px');
				} else {
					this.spacer.setStyle('background-position', '0px -' + (this.imageHeight) + 'px');
				}
			}
		}.bind(this)); 
	},
	
	getImageHeight: function(item){
		if (item.hasClass('checkbox')) {
			this.imageHeight = this.options.checkboxImage.height;
		} else {
			this.imageHeight = this.options.radioImage.height;
		}
	},
 	
    effect: function(item){
	  	
		this.getImageHeight(item);
		
        if(item.className == 'checkbox' || item.className == 'radio') {
            item.getElement('img').setStyle('background-position', '0px -' + this.imageHeight + 'px');
		} else {
			item.getElement('img').setStyle('background-position', '0px -' + (this.imageHeight * 3) + 'px');
		}
	},
 
    handle: function(item){
    
        selector = item.getElement('input');
		
        if(item.className == 'checkbox') {
            selector.setProperty('checked', 'checked');
            item.addClass('selected');
			item.getElement('img').setStyle('background-position', '0px -' + (this.options.checkboxImage.height * 2) + 'px');
		} else if (item.className == 'checkbox selected') {
            selector.removeProperty('checked');
            item.removeClass('selected');
			item.getElement('img').setStyle('background-position', '0px 0px');
		} else {
            selector.setProperty('checked', 'checked');
            item.addClass('selected');
			item.getElement('img').setStyle('background-position', '0px -' + (this.options.radioImage.height * 2) + 'px');
            itemName = selector.getProperty('name');
            
			this.inputs = this.el.getElements('input[name=' + itemName + ']');
            
            this.inputs.each(function(radio){
                if (radio != selector) {
                    radio.getParent().removeProperty('checked');
                    radio.getParent().removeClass('selected');
					if (!radio.getParent().hasClass('disabled')) { 	
						radio.getParent().getElement('img').setStyle('background-position', '0px 0px');
					}
				}
			});
		}
	},
    
    clear: function(item){
		
	   	this.getImageHeight(item);
		
        if (item.className == 'checkbox' || item.className == 'radio') {
			item.getElement('img').setStyle('background-position', '0px 0px');
		} else if (item.className == 'checkbox selected' || item.className == 'radio selected') {
			item.getElement('img').setStyle('background-position', '0px -' + (this.imageHeight * 2) + 'px');
		}
	}
});
