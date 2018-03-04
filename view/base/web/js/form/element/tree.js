/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'Magento_Ui/js/form/element/abstract',
    'mage/translate',
    'ko',
    'jquery',
    'jquery/ui'
], function (Abstract, translate, ko, jQuery, jQueryUi) {
    'use strict';

    return Abstract.extend({
        defaults: {
            elementTmpl: 'MagentoYo_Menu/form/element/tree',
        },
        
        // Data observables
        dataForm: null,
        dataTree: null,
        
        // Tree
        addSubElement: function($data, $element) {
            var _self = this;
            var updatedData = $data.dataTree();
            updatedData.push({
                'dataItem' : ko.observable({
                   'title' : '...',
                   'link'  : '#',
                   'identifier' : _self.indentifierCounter++,
                }),
                'dataTree'  : ko.observable([])
            });
            
            $data.dataTree(updatedData);
            
            this.hideForm();
            this.toValue();
        },
        
        editElement: function($data, $parent) {
            this.dataFormBuffer.data = $data;
            this.dataFormBuffer.parent = $parent;
            
            this.dataForm({
                'label': $data.dataItem().title,
                'link': $data.dataItem().link,
                'shown': true
            })
        },
        
        removeElement: function($data, $parent) {
            var $dataItem = $data.dataItem();
            $dataItem.action = 'remove';
            $data.dataItem($dataItem);
            
            var parentDataTree = jQuery.grep($parent.dataTree(), function(value) {
                if (value.dataItem().action == 'remove') {
                    return false;
                }
                
                return true;
            });
            
            $parent.dataTree(parentDataTree);
            
            this.hideForm();
            this.toValue();
        },
        
        // Edit form
        dataFormBuffer: {},
        
        showForm: function() {
            var dataForm = this.dataForm();
            dataForm.shown = true;
            
            this.dataForm(dataForm);
        },
        
        hideForm: function() {
            this.dataForm({
                'shown': false
            });
        },
        
        dataFormSave: function () {
            var $data = this.dataFormBuffer.data;
            var $dataItem = $data.dataItem();
            
            $dataItem.title = this.dataForm().label;
            $dataItem.link = this.dataForm().link;
            
            $data.dataItem($dataItem);
            this.toValue();
        },
        
        toValue: function() {
            var dataJS = ko.toJSON(this.dataTree());
            this.value(dataJS);
        },
        
        fromValue: function() {
            if (!this.value()) {
                this.value('[]');
            }
            
            var parsedValue = JSON.parse(this.value());
            var koValue = ko.observable(parsedValue);
            this._fromValueConvert(koValue);
            
            return koValue;
        },
        
        indentifierCounter: 0,
        
        _fromValueConvert: function(dataObservableArray) {
            var _self = this;
            jQuery(dataObservableArray()).each(function(key, value){
                value.dataItem.identifier = _self.indentifierCounter++;
                value.dataItem = ko.observable(value.dataItem);
                value.dataTree = ko.observable(value.dataTree);
                
                _self._fromValueConvert(value.dataTree);
            })
        },
        
        setInitialValue: function () {
            this._super();
            
            this.dataForm = ko.observable({
                label: 'SampleLabel',
                link: 'SampleLink',
                shown: false
            });
            
            this.dataTree = this.fromValue();
            
            return this;
        },
        
        initSortableTree: function() {
            var self = this;
            jQuery('.admin__action-w3site-tree .sortable-tree').sortable({
                connectWith: ".admin__action-w3site-tree .sortable-tree",
                handle: ".moveButton",
                update: function( event, ui ) {
                    if (!ui.item.is(':visible')) {
                        return;
                    }
                    
                    var currentElement = jQuery(ui.item);
                    var prevElement = jQuery(ui.item).prev();
                    var parentElement = jQuery(ui.item).parent().parent();

                    var currentId = currentElement.attr('data-identifier');
                    
                    var movedAfterId = null;
                    if (prevElement.length > 0) {
                        movedAfterId = prevElement.attr('data-identifier');
                    }
                    
                    var parentId = null;
                    if (parentElement.length > 0) {
                        parentId = parentElement.attr('data-identifier');
                    }
                    
                    self.moveElement.call(self, currentId, parentId, movedAfterId);
                    ui.item.remove();
                }
            }).disableSelection();
        },
        
        moveElementGrepRemove: function(dataTree, currentId) {
            var moveElement;
            var self = this;
            
            var parentDataTree = jQuery.grep(dataTree(), function(value) {
                if (value.dataItem().identifier == currentId) {
                    moveElement = value;
                    return false;
                }
                
                if (value.dataTree().length > 0 && !moveElement) {
                    moveElement = self.moveElementGrepRemove(value.dataTree, currentId);
                }
                
                return true;
            });
            dataTree(parentDataTree)
            
            return moveElement;
        },
        
        moveElementGrepInsert: function(dataTree, movedParent) {
            var moveToStatement;
            var self = this;
            
            jQuery.grep(dataTree(), function(value) {
                if (value.dataItem().identifier == movedParent) {
                    moveToStatement = value.dataTree;
                }
                
                if (!moveToStatement) {
                    moveToStatement = self.moveElementGrepInsert(value.dataTree, movedParent);
                }
            })
            
            return moveToStatement;
        },
        
        moveElement: function(currentId, movedParent, movedAfterId) {
            var moveElement = this.moveElementGrepRemove(this.dataTree, currentId);
debugger;
            var moveTo = this.dataTree();
            var moveToStatement = this.dataTree;
            
            if (movedParent) {
                moveToStatement = this.moveElementGrepInsert(this.dataTree, movedParent);
                moveTo = moveToStatement();
                
                debugger;
                //!!!
                /*
                jQuery.grep(this.dataTree(), function(value) {
                    if (value.dataItem().identifier == movedParent) {
                        moveTo = value.dataTree();
                        moveToStatement = value.dataTree;
                    }
                })
                */
            }
            
            if (movedAfterId) {
                var newArray = [];
                for (var key in moveTo) {
                    newArray.push(moveTo[key]);
                    if (moveTo[key].dataItem().identifier == movedAfterId) {
                        newArray.push(moveElement);
                    }
                }
                
                moveTo = newArray;
            }
            else {
                moveTo.unshift(moveElement);
            }
            
            moveToStatement(moveTo);
            debugger;
            
            this.hideForm();
            this.toValue();
        }
    });
});
