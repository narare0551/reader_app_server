var FNRGrid = function() {
    return $.extend({}, this, {
        grid : null,
        name : '',
        setGrid: function (div_id, row_height, header_name,header,toolbar,footer,lineNumbers,selectColumn,expandColumn,multiSelect) {
            this.grid = $('#' + div_id).w2grid({
                name: div_id,
                header: header_name,
                recordHeight : row_height,
                multiSelect: multiSelect,
                show: {
                    header         : header,
                    toolbar     : toolbar,
                    footer        : footer,
                    lineNumbers    : lineNumbers,
                    selectColumn: selectColumn,
                    expandColumn: expandColumn
                },
            });
            this.name = div_id;
        },
        setColumns: function (columns) {
            for(var i=0;i<columns.length;i++) {
                this.grid.addColumn(columns[i]);
            }
        },
        setColumnsnAutoresize: function (columns) {
            var total_size = 0;
            for(var i=0;i<columns.length;i++) {
                total_size += parseInt(columns[i].size.replace('px',''));
            }
            $('#' + this.name).width(total_size);
            for(var i=0;i<columns.length;i++) {
                this.grid.addColumn(columns[i]);
            }
            return total_size;
        },
        getColumns: function () {
            return this.grid.getColumn();
        },
        addColumn: function (column) {
            this.grid.addColumn(column);
        },
        addRow: function (data) {
            if(!data) {
                var g = this.grid.records.length;
                var columns = this.grid.getColumn();
                var new_data = '[{' + '"recid": ' + (g + 1) + ', ';
                for(var i=0;i<columns.length;i++)
                {
                    new_data += '"' + columns[i] + '":null ';
                    if(i<columns.length-1)
                    {
                        new_data += ',';
                    }
                }
                new_data += '}]';
                new_data = JSON.parse(new_data);
                this.grid.add(new_data);
            }
            else
            {
                if(data.recid == '')
                {
                    data.recid = this.grid.records.length + 1;
                    this.grid.add(data);

                }
                else {
                    this.grid.add(data);
                }
            }
        },
        removeRow: function () {
            var recids = this.grid.getSelection();
            var return_data = [];
            for(var i=0;i< recids.length;i++)
            {
                return_data.push(this.grid.get(recids[i]));
                this.grid.remove(recids[i]);
            }
            return return_data;
        },
        removeCheckRow: function () {

        },
        eventGrid : function(event_type, runfunction, type)
        {
            this.grid.on(event_type, function(event) {
                if(IsNullorEmpty(type) || type == 'complete') {
                    event.onComplete = function () {
                        runfunction(event);
                    }
                }
                else if(type == 'done') {
                    event.done(function () {
                        runfunction(event);
                    });
                }
            });
        },
        setRowData : function(recid, data)
        {
            this.grid.set(recid, data);
        },
        setAllData : function(data)
        {
            this.grid.clear();
            this.grid.add(data);
        },
        setColData : function(data)
        {
            this.grid.set(data);
        },
        getRowData : function(recid)
        {
            if(recid) {
                return this.grid.get(recid);
            }
            else
            {
                return this.grid.records;
            }
        },
        reloadData : function()
        {
            this.grid.reload();
        },
        clearData : function()
        {
            this.grid.clear();
        },
        resetGrid : function()
        {
            this.grid.reset();
        },
        save : function()
        {
            this.grid.save();
        },
        lock : function(type, msg)
        {
            if(type == true)
            {
                this.grid.lock(msg, true);
            }
            else
            {
                this.grid.unlock();
            }
        },
        getSelection : function()
        {
            return this.grid.getSelection();
        },
        setSelectIdx : function(idx)
        {
            var recid = this.grid.find({idx : idx});
            this.grid.selectNone();
            this.grid.select(recid[0]);
        },
        editFocus : function(recid, col_num)
        {
            this.grid.editField(recid, col_num);
        },
        findData : function(column_name, data)
        {
            var json_column_name = '{"' + column_name + '":"' + data + '"}';
            json_column_name = JSON.parse(json_column_name);
            return this.grid.find(json_column_name);
        },
        setUnSelection : function()
        {
            this.grid.selectNone();
        }
    })
}
//         //리스트 데이터 imnport
//         setGridDatas: function (data) {
//             this.grid.setData(data);
//         },
//         //한줄데이터 추가
//         addRows: function (data, parent_rowkey) {
//             if (parent_rowkey == null) {
//                 this.grid.appendRow(data, {parentRowKey: null});
//             }
//             else {
//                 this.grid.appendRow(data, parent_rowkey);
//             }
//         },
//         //한줄데이터 가져오기
//         getRowData: function (rowKey) {
//             return this.grid.getRow(rowKey);
//         },
//         //전체데이터 가져오기
//         getRows: function () {
//             return this.grid.getRows();
//         },
//         //데이터 카운터 가져오기
//         getRowCount: function () {
//             return this.grid.getRowCount();
//         },
//         //로우 셀렉트 버그수정중
//         setRowSelection: function (rowKey) {
//             var range = {start: [rowKey, 0], end: [rowKey, this.column_count - 1]};
//             return this.grid.selection(range);
//         },
//         //row삭제
//         removeRow: function (rowKey) {
//             this.grid.removeRow(rowKey, true);
//         },
//         //리스트 초기화
//         clearGrid: function () {
//             this.removeRow();
//         },
//         //리스트 리프레쉬
//         refreshLayout: function () {
//             this.grid.refreshLayout();
//         },
//         destroy: function() {
//             this.grid.destroy();
//         },
//         //칼럼숨기기
//         hideColumn: function (column_id) {
//             this.grid.hideColumn(column_id);
//         },
//         //숨긴 칼럼 보이기
//         showColumn: function (column_id) {
//             this.grid.showColumn(column_id);
//         },
//         //한줄선택
//         selectRow: function (rowKey) {
//             this.grid.disableRow(rowKey);
//         },
//         //리스트 전체 선택
//         selectAllRows: function () {
//             this.grid.disable();
//         },
//         //리스트 선택 해제
//         unselectRow: function (rowKey) {
//             this.grid.enableRow(rowKey);
//         },
//         //리스트 선택 해제
//         unselectAllRow: function () {
//             this.grid.enable();
//         },
//         //한출체크
//         checkRow: function (rowKey) {
//             this.grid.check(rowKey);
//         },
//         //리스트 전체 체크
//         checkAllRows: function () {
//             this.grid.checkAll();
//         },
//         //리스트 체크 해제
//         uncheckRow: function (rowKey) {
//             this.grid.uncheck(rowKey);
//         },
//         //리스트 전체 체크 해제
//         uncheckAllRow: function () {
//             this.grid.uncheckAll();
//         },
//         enableRow: function (rowKey) {
//             this.grid.enableRow(rowKey);
//         },
//         disableRow: function (rowKey) {
//             this.grid.disableRow(rowKey);
//         },
//         setValue: function(rowKey, columnName, columnValue) {
//             this.grid.setValue(rowKey, columnName, columnValue);
//         },
//         focus: function (rowKey, column_id, isScrollableopt) {
//             this.grid.enableRow(rowKey, column_id, isScrollableopt);
//         },
//         convertColumnData: function (columns) {
//             var return_data = [];
//             var count = 0;
//             $.each(columns, function (key, value) {
//                 return_data.push({
//                     title: value.name,
//                     name: value.id,
//                     width: value.hasOwnProperty('width')? value.width : null,
//                     sortable: value.hasOwnProperty('sortable') ? value.sortable : false,
//                     formatter: value.hasOwnProperty('formatter') ? value.formatter : function (data) {
//                         return '<span style="' + value.style + '">' + data + '</span>';
//                     },
//                     whiteSpace: value.hasOwnProperty('whiteSpace')? value.whiteSpace : null,
//                     editOptions: {
//                         type: value.type,
//                         align: 'center',
//                         useViewMode: value.useViewMode,
//                         listItems: value.hasOwnProperty('listItems') ? value.listItems : null,
//                         onFocus:  value.hasOwnProperty('onFocus')?
//                             function(ev, obj) {
//                                 onFocusInput(ev, obj);
//                             }:null
//                     },
//                     component: value.hasOwnProperty('component') ? value.component : null,
//                     onAfterChange: value.hasOwnProperty('onAfterChange')?
//                         function(ev) {
//                             onAfterChange(ev);
//                         }:null,
//                     onBeforeChange: value.hasOwnProperty('onBeforeChange')?
//                         function(ev) {
//                             onBeforeChange(ev);
//                         }:null
//                     // onAfterChange: function(ev) {
//                     //     onAfterChange(ev);
//                     // }
//                     // relations: value.hasOwnProperty('targetNames')?
//                     // [{
//                     //     targetNames: value.targetNames,
//                     //     listItems: function(value) {
//                     //         return twoDepthData[value];
//                     //     },
//                     //     disabled: function(value) {
//                     //         return !(value);
//                     //     }
//                     // }]:null
//                 });
//
//             });
//             return return_data;
//         },
//         convertTreeDataList: function (data_list, child_column_name, parenta_column_name,treeState) {
//             var return_data = [];
//             for (var i = 0; i < data_list.length; i++) {
//                 // if (data_list[i][child_column_name] != '' && data_list[i][parenta_column_name] == '') {
//                 if (data_list[i][child_column_name] != '' && data_list[i][parenta_column_name] == '') {
//                     return_data.push(data_list[i]);
//                     data_list.splice(i, 1);
//                     i--;
//                 }
//             }
//             for (var i = 0; i < return_data.length; i++) {
//                 var child_data = [];
//                 for (var j = 0; j < data_list.length; j++) {
//                     if (return_data[i][child_column_name] == data_list[j][parenta_column_name]) {
//                         data_list[j] = convertTreeChildrenDataList(data_list[j],data_list,child_column_name,parenta_column_name,treeState);
//                         child_data.push(data_list[j]);
//                         data_list.splice(j, 1);
//                         j--;
//                     }
//                 }
//                 if (child_data.length > 0) {
//                     var temp = {
//                         _extraData: {
//                             treeState: treeState
//                         },
//                         _children: child_data
//                     };
//                     return_data[i] = $.extend({}, return_data[i], temp);
//                 }
//
//                 return_data[i]['veiw_icon'] = '<i class="'+return_data[i]['menu_icon']+'"></i>';
//             }
//
//             if(return_data.length == 0) return_data = data_list;
//             return return_data;
//
//         }
//     });
// };