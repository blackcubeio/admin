(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["app"],{

/***/ "./app.ts":
/*!****************!*\
  !*** ./app.ts ***!
  \****************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var _this = this;
Object.defineProperty(exports, "__esModule", { value: true });
var aurelia_bootstrapper_1 = __webpack_require__(/*! aurelia-bootstrapper */ "../../../../node_modules/aurelia-bootstrapper/dist/native-modules/aurelia-bootstrapper.js");
var aurelia_framework_1 = __webpack_require__(/*! aurelia-framework */ "aurelia-framework");
aurelia_bootstrapper_1.bootstrap(function (aurelia) {
    aurelia.use
        .standardConfiguration()
        .plugin('aurelia-validation')
        .plugin('components/index');
    if (true) {
        aurelia.use.developmentLogging();
    }
    /* full aurelia app /
    let baseApp = document.querySelector('[data-app]');
    // @ts-ignore
    aurelia.start().then(() => aurelia.setRoot(PLATFORM.moduleName('App'), baseApp));
    /* full aurelia app */
    /* enhance aurelia app */
    aurelia.start().then(function () {
        return aurelia.enhance(document);
    });
    /* enhance aurelia app */
    if (!Element.prototype.matches) {
        // @ts-ignore
        Element.prototype.matches = Element.prototype.msMatchesSelector || Element.prototype.webkitMatchesSelector;
    }
    if (!Element.prototype.closest) {
        Element.prototype.closest = function (s) {
            var el = _this;
            // @ts-ignore
            if (!document.documentElement.contains(el))
                return null;
            do {
                if (el.matches(s))
                    return el;
                el = el.parentElement || el.parentNode;
            } while (el !== null && el.nodeType == 1);
            return null;
        };
    }
});


/***/ }),

/***/ "./app/services/AjaxService.ts":
/*!*************************************!*\
  !*** ./app/services/AjaxService.ts ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
Object.defineProperty(exports, "__esModule", { value: true });
var aurelia_framework_1 = __webpack_require__(/*! aurelia-framework */ "aurelia-framework");
var aurelia_fetch_client_1 = __webpack_require__(/*! aurelia-fetch-client */ "../../../../node_modules/aurelia-fetch-client/dist/native-modules/aurelia-fetch-client.js");
var AjaxService = /** @class */ (function () {
    function AjaxService(httpClient) {
        this.logger = aurelia_framework_1.LogManager.getLogger('services.AjaxService');
        this.httpClient = httpClient;
        this.httpClient.configure(function (config) {
            config
                .withDefaults({
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'include'
            });
        });
        this.logger.debug('Constructor');
    }
    AjaxService.prototype.getBlocs = function (route, formData) {
        this.logger.debug('getBlocs', route);
        return this.httpClient.fetch(route, {
            method: 'post',
            body: formData,
        });
    };
    AjaxService = __decorate([
        aurelia_framework_1.inject(aurelia_fetch_client_1.HttpClient)
    ], AjaxService);
    return AjaxService;
}());
exports.AjaxService = AjaxService;


/***/ }),

/***/ "./boot.ts":
/*!*****************!*\
  !*** ./boot.ts ***!
  \*****************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

if (webpackBaseUrl !== undefined) {
    __webpack_require__.p = webpackBaseUrl;
}


/***/ }),

/***/ 0:
/*!********************************************************************************!*\
  !*** multi aurelia-webpack-plugin/runtime/pal-loader-entry ./boot.ts ./app.ts ***!
  \********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! aurelia-webpack-plugin/runtime/pal-loader-entry */"../../../../node_modules/aurelia-webpack-plugin/runtime/pal-loader-entry.js");
__webpack_require__(/*! ./boot.ts */"./boot.ts");
module.exports = __webpack_require__(/*! ./app.ts */"./app.ts");


/***/ }),

/***/ 1:
/*!***********************!*\
  !*** vertx (ignored) ***!
  \***********************/
/*! no static exports found */
/***/ (function(module, exports) {

/* (ignored) */

/***/ }),

/***/ "components/HtmlLoaderCustomAttribute":
/*!*****************************************************!*\
  !*** ./app/components/HtmlLoaderCustomAttribute.ts ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
Object.defineProperty(exports, "__esModule", { value: true });
var aurelia_framework_1 = __webpack_require__(/*! aurelia-framework */ "aurelia-framework");
var aurelia_event_aggregator_1 = __webpack_require__(/*! aurelia-event-aggregator */ "aurelia-event-aggregator");
var HtmlLoaderCustomAttribute = /** @class */ (function () {
    function HtmlLoaderCustomAttribute(element, eventAggregator) {
        var _this = this;
        this.logger = aurelia_framework_1.LogManager.getLogger('components.HtmlLoader');
        this.onRemoveLoader = function (data) {
            _this.logger.debug('Remove loader');
            _this.element.style.display = 'none';
        };
        this.element = element;
        this.eventAggregator = eventAggregator;
        this.logger.debug('Constructor');
    }
    HtmlLoaderCustomAttribute.prototype.created = function (owningView, myView) {
        this.logger.debug('Created');
    };
    HtmlLoaderCustomAttribute.prototype.bind = function (bindingContext, overrideContext) {
        this.logger.debug('Bind');
    };
    HtmlLoaderCustomAttribute.prototype.attached = function () {
        this.logger.debug('Attached');
        this.subscriber = this.eventAggregator.subscribe('RemoveLoader', this.onRemoveLoader);
    };
    HtmlLoaderCustomAttribute.prototype.detached = function () {
        this.logger.debug('Detached');
        this.subscriber.dispose();
    };
    HtmlLoaderCustomAttribute.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    HtmlLoaderCustomAttribute = __decorate([
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element, aurelia_event_aggregator_1.EventAggregator)
    ], HtmlLoaderCustomAttribute);
    return HtmlLoaderCustomAttribute;
}());
exports.HtmlLoaderCustomAttribute = HtmlLoaderCustomAttribute;


/***/ }),

/***/ "components/LoaderDoneCustomAttribute":
/*!*****************************************************!*\
  !*** ./app/components/LoaderDoneCustomAttribute.ts ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
Object.defineProperty(exports, "__esModule", { value: true });
var aurelia_framework_1 = __webpack_require__(/*! aurelia-framework */ "aurelia-framework");
var aurelia_event_aggregator_1 = __webpack_require__(/*! aurelia-event-aggregator */ "aurelia-event-aggregator");
var LoaderDoneCustomAttribute = /** @class */ (function () {
    function LoaderDoneCustomAttribute(element, eventAggregator) {
        var _this = this;
        this.logger = aurelia_framework_1.LogManager.getLogger('components.LoaderDone');
        this.onRemoveLoader = function (data) {
            _this.logger.debug('Remove loader');
            _this.element.style.display = 'none';
        };
        this.element = element;
        this.eventAggregator = eventAggregator;
        this.logger.debug('Constructor');
    }
    LoaderDoneCustomAttribute.prototype.created = function (owningView, myView) {
        this.logger.debug('Created');
    };
    LoaderDoneCustomAttribute.prototype.bind = function (bindingContext, overrideContext) {
        this.logger.debug('Bind');
    };
    LoaderDoneCustomAttribute.prototype.attached = function () {
        this.logger.debug('Attached');
        this.eventAggregator.publish('RemoveLoader', {});
    };
    LoaderDoneCustomAttribute.prototype.detached = function () {
        this.logger.debug('Detached');
    };
    LoaderDoneCustomAttribute.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    LoaderDoneCustomAttribute = __decorate([
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element, aurelia_event_aggregator_1.EventAggregator)
    ], LoaderDoneCustomAttribute);
    return LoaderDoneCustomAttribute;
}());
exports.LoaderDoneCustomAttribute = LoaderDoneCustomAttribute;


/***/ }),

/***/ "components/ManageBlocsCustomAttribute":
/*!******************************************************!*\
  !*** ./app/components/ManageBlocsCustomAttribute.ts ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
Object.defineProperty(exports, "__esModule", { value: true });
var aurelia_framework_1 = __webpack_require__(/*! aurelia-framework */ "aurelia-framework");
var AjaxService_1 = __webpack_require__(/*! ../services/AjaxService */ "./app/services/AjaxService.ts");
var ManageBlocsCustomAttribute = /** @class */ (function () {
    function ManageBlocsCustomAttribute(element, ajaxService) {
        var _this = this;
        this.logger = aurelia_framework_1.LogManager.getLogger('components.ManageBlocs');
        this.onClick = function (evt) {
            var currentTarget = evt.currentTarget;
            _this.logger.debug('Click button');
            var button = currentTarget;
            if (button.name) {
                var formData = new FormData(_this.form);
                formData.append(button.name, button.value);
                _this.detachEventHandler();
                _this.ajaxService.getBlocs(_this.url, formData)
                    .then(function (response) {
                    if (response.status == 200) {
                        response.text().then(function (text) {
                            var target = _this.element.querySelector('.target');
                            if (target) {
                                target.innerHTML = text;
                            }
                            else {
                                _this.logger.debug('Error target', text);
                            }
                        });
                    }
                    setTimeout(function () {
                        _this.attachEventHandler();
                    }, 0);
                })
                    .catch(function (reason) {
                    _this.attachEventHandler();
                });
            }
        };
        this.element = element;
        this.ajaxService = ajaxService;
        this.logger.debug('Constructor');
    }
    ManageBlocsCustomAttribute.prototype.created = function (owningView, myView) {
        this.logger.debug('Created');
    };
    ManageBlocsCustomAttribute.prototype.bind = function (bindingContext, overrideContext) {
        this.logger.debug('Bind');
    };
    ManageBlocsCustomAttribute.prototype.attached = function () {
        this.logger.debug('Attached');
        this.logger.debug(this.url);
        this.form = this.element.closest('form');
        this.attachEventHandler();
        // let formData = new FormData(this.form);
        // this.ajaxService.getBlocs(this.url, formData);
    };
    ManageBlocsCustomAttribute.prototype.attachEventHandler = function () {
        var _this = this;
        this.subButtons = this.element.querySelectorAll('button[type=button]');
        this.subButtons.forEach(function (button, key, parent) {
            button.addEventListener('click', _this.onClick);
        });
    };
    ManageBlocsCustomAttribute.prototype.detachEventHandler = function () {
        var _this = this;
        this.subButtons.forEach(function (button, key, parent) {
            button.removeEventListener('click', _this.onClick);
        });
    };
    ManageBlocsCustomAttribute.prototype.detached = function () {
        var _this = this;
        this.logger.debug('Detached');
        this.subButtons.forEach(function (button, key, parent) {
            button.removeEventListener('click', _this.onClick);
        });
    };
    ManageBlocsCustomAttribute.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    __decorate([
        aurelia_framework_1.bindable({ primaryProperty: true })
    ], ManageBlocsCustomAttribute.prototype, "url", void 0);
    ManageBlocsCustomAttribute = __decorate([
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element, AjaxService_1.AjaxService)
    ], ManageBlocsCustomAttribute);
    return ManageBlocsCustomAttribute;
}());
exports.ManageBlocsCustomAttribute = ManageBlocsCustomAttribute;


/***/ }),

/***/ "components/SchemaEditorCustomElement":
/*!*****************************************************!*\
  !*** ./app/components/SchemaEditorCustomElement.ts ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
var aurelia_framework_1 = __webpack_require__(/*! aurelia-framework */ "aurelia-framework");
var jsoneditor_1 = __importDefault(__webpack_require__(/*! jsoneditor */ "../../../../node_modules/jsoneditor/index.js"));
var SchemaEditorCustomElement = /** @class */ (function () {
    function SchemaEditorCustomElement(element) {
        this.logger = aurelia_framework_1.LogManager.getLogger('components.SchemaEditor');
        this.element = element;
        this.logger.debug('Constructor');
    }
    SchemaEditorCustomElement.prototype.created = function (owningView, myView) {
        this.logger.debug('Created');
    };
    SchemaEditorCustomElement.prototype.bind = function (bindingContext, overrideContext) {
        this.logger.debug('Bind');
    };
    SchemaEditorCustomElement.prototype.attached = function () {
        this.hiddenField = this.element.querySelector('input[type=hidden]');
        if (this.hiddenField) {
            if (this.fieldId) {
                this.hiddenField.id = this.fieldId;
            }
            if (this.fieldName) {
                this.hiddenField.name = this.fieldName;
            }
            if (this.schema) {
                this.hiddenField.value = this.schema;
            }
        }
        this.jsonEditorElement = this.element.querySelector('div');
        if (this.jsonEditorElement) {
            this.buildEditor();
        }
        this.logger.debug('Attached');
    };
    SchemaEditorCustomElement.prototype.detached = function () {
        this.logger.debug('Detached');
    };
    SchemaEditorCustomElement.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    SchemaEditorCustomElement.prototype.buildEditor = function () {
        var _this = this;
        var config = {
            mode: "tree",
            search: false,
            navigationBar: false,
            statusBar: false,
            mainMenuBar: false,
            language: "en"
        };
        if (this.language) {
            config.language = this.language;
        }
        if (this.hiddenField) {
            config.onChangeJSON = function (jsonData) {
                // @ts-ignore
                _this.hiddenField.value = JSON.stringify(jsonData, null, 4);
            };
        }
        this.jsonSchema = new jsoneditor_1.default(this.jsonEditorElement, config);
        this.jsonSchema.setText(this.schema);
        this.jsonSchema.expandAll();
    };
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], SchemaEditorCustomElement.prototype, "fieldId", void 0);
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], SchemaEditorCustomElement.prototype, "fieldName", void 0);
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], SchemaEditorCustomElement.prototype, "schema", void 0);
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], SchemaEditorCustomElement.prototype, "language", void 0);
    SchemaEditorCustomElement = __decorate([
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element)
    ], SchemaEditorCustomElement);
    return SchemaEditorCustomElement;
}());
exports.SchemaEditorCustomElement = SchemaEditorCustomElement;


/***/ }),

/***/ "components/SchemaEditorCustomElement.html":
/*!*******************************************************!*\
  !*** ./app/components/SchemaEditorCustomElement.html ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<template>\n    <input type=\"hidden\" />\n    <div></div>\n</template>\n";

/***/ }),

/***/ "components/ToggleBlocCustomAttribute":
/*!*****************************************************!*\
  !*** ./app/components/ToggleBlocCustomAttribute.ts ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
Object.defineProperty(exports, "__esModule", { value: true });
var aurelia_framework_1 = __webpack_require__(/*! aurelia-framework */ "aurelia-framework");
var aurelia_event_aggregator_1 = __webpack_require__(/*! aurelia-event-aggregator */ "aurelia-event-aggregator");
var ToggleBlocCustomAttribute = /** @class */ (function () {
    function ToggleBlocCustomAttribute(element, eventAggregator) {
        var _this = this;
        this.logger = aurelia_framework_1.LogManager.getLogger('components.ToggleBloc');
        this.toggleBlocInitialDisplay = 'inherit';
        this.onToggle = function () {
            if (_this.toggleBloc) {
                if (_this.toggleBloc.style.display === 'none') {
                    _this.toggleBloc.style.display = _this.toggleBlocInitialDisplay;
                }
                else {
                    _this.toggleBloc.style.display = 'none';
                }
            }
        };
        this.onChange = function () {
            if (_this.toggleBloc && _this.toggleCheckbox) {
                if (_this.toggleCheckbox.checked) {
                    _this.toggleBloc.style.display = _this.toggleBlocInitialDisplay;
                }
                else {
                    _this.toggleBloc.style.display = 'none';
                }
            }
        };
        this.element = element;
        this.eventAggregator = eventAggregator;
        this.logger.debug('Constructor');
    }
    ToggleBlocCustomAttribute.prototype.created = function (owningView, myView) {
        this.logger.debug('Created');
    };
    ToggleBlocCustomAttribute.prototype.bind = function (bindingContext, overrideContext) {
        this.logger.debug('Bind');
    };
    ToggleBlocCustomAttribute.prototype.attached = function () {
        this.toggleCheckbox = this.element.querySelector('.toggle');
        this.toggleBloc = this.element.querySelector('.toggle-target');
        this.titleBloc = this.element.firstElementChild;
        if (this.toggleBloc) {
            this.toggleBlocInitialDisplay = this.toggleBloc.style.display;
            this.toggleBloc.style.display = 'none';
        }
        if (this.toggleCheckbox) {
            this.toggleCheckbox.addEventListener('change', this.onChange);
        }
        if (this.titleBloc && this.toggleBloc) {
            this.titleBloc.addEventListener('click', this.onToggle);
        }
        this.eventAggregator.publish('RemoveLoader', {});
        this.logger.debug('Attached');
    };
    ToggleBlocCustomAttribute.prototype.detached = function () {
        this.logger.debug('Detached');
    };
    ToggleBlocCustomAttribute.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    ToggleBlocCustomAttribute = __decorate([
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element, aurelia_event_aggregator_1.EventAggregator)
    ], ToggleBlocCustomAttribute);
    return ToggleBlocCustomAttribute;
}());
exports.ToggleBlocCustomAttribute = ToggleBlocCustomAttribute;


/***/ }),

/***/ "components/index":
/*!*********************************!*\
  !*** ./app/components/index.ts ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", { value: true });
var aurelia_framework_1 = __webpack_require__(/*! aurelia-framework */ "aurelia-framework");
function configure(configure) {
    configure.globalResources([
        'components/SchemaEditorCustomElement',
        'components/ToggleBlocCustomAttribute',
        'components/HtmlLoaderCustomAttribute',
        'components/LoaderDoneCustomAttribute',
        'components/ManageBlocsCustomAttribute'
    ]);
}
exports.configure = configure;


/***/ })

},[[0,"manifest","aurelia","vendor"]]]);
//# sourceMappingURL=app.js.map