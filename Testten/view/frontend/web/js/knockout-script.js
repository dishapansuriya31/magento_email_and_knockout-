define(['jquery', 'uiComponent', 'ko', 'mage/storage'], function ($, Component, ko, storage) {
    'use strict';
    return Component.extend({
        defaults: {
            template: 'Kitchen_Testten/knockout-test'
        },
        initialize: function () {
            this._super();
            this.tabName = ko.observableArray([]);
            this.tabData = ko.observable('');
            this.columns = ko.observableArray([]); 
            this.items = ko.observableArray([]);  
            this._render(); 
        },
        addNewTab: function () {
            var self = this;
            var tabData = this.tabData();
            if (tabData) {
                storage.post('ten/index/save', JSON.stringify({
                    "field": 'TabName',
                    "value": this.tabData()
                }), true)
                    .done(function (response) {
                        if (response.success) {
                            self.tabName.push({ namegridData: self.tabData() });
                            alert('Tab Added successfully.');
                        } else {
                            alert('Failed to add tab. Please try again.');
                        }
                    })
                    .fail(function () {
                        alert('Error occurred. Please try again.');
                    });
            } else {
                alert('Please enter a tab name.');
            }
            this.tabData('');
        },
        _render: function () {
            this._prepareColumns();
            this._prepareItems();
        },
        _prepareItems: function () {
            
            var items = window.grid_data;
            for (var i = 0; i < items.length; i++) {
                this.addItem(items[i]);
            }
        },
        _prepareColumns: function () {
           
            this.addColumn({ headerText: "Tab Name", rowText: "tab_name", renderer: '' });
           
        },
        addItem: function (item) {
            item.columns = this.columns;
            this.items.push(item);
        },
        addColumn: function (column) {
            this.columns.push(column);
        }
    });
});
