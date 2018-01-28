/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'Magento_Ui/js/form/element/abstract',
    'mage/translate',
    'ko',
    'jquery'
], function (Abstract, translate, ko, jQuery) {
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
            var updatedData = $data.dataTree();
            updatedData.push({
                'dataItem' : ko.observable({
                   'title' : '...',
                   'link'  : '#'
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
        
        _fromValueConvert: function(dataObservableArray) {
            var _self = this;
            jQuery(dataObservableArray()).each(function(key, value){
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
        }
    });
});
