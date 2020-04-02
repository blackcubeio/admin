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
        this.modal = null;
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
    AjaxService.prototype.getModal = function () {
        this.logger.debug('getModal');
        if (this.modal === null) {
            this.modal = this.httpClient.fetch('/admin/ajax/modal', {
                method: 'get'
            }).then(function (response) {
                return response.text();
            });
        }
        return this.modal;
    };
    AjaxService.prototype.getDetailModal = function (type, id) {
        this.logger.debug('getDetailModal');
        this.modal = this.httpClient.fetch('/admin/ajax/modal?id=' + id + '&type=' + type, {
            method: 'get'
        }).then(function (response) {
            return response.text();
        });
        return this.modal;
    };
    AjaxService.prototype.getRequest = function (url) {
        this.logger.debug('getRequest');
        return this.httpClient.fetch(url, { method: 'get' })
            .then(function (response) {
            return response.text();
        });
    };
    AjaxService.prototype.deleteRequest = function (url, csrf) {
        if (csrf === void 0) { csrf = ''; }
        this.logger.debug('deleteRequest');
        return this.httpClient.fetch(url, { method: 'delete', headers: { 'X-CSRF-Token': csrf } });
    };
    AjaxService = __decorate([
        aurelia_framework_1.inject(aurelia_fetch_client_1.HttpClient)
    ], AjaxService);
    return AjaxService;
}());
exports.AjaxService = AjaxService;


/***/ }),

/***/ "./app/services/StorageService.ts":
/*!****************************************!*\
  !*** ./app/services/StorageService.ts ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", { value: true });
var StorageService = /** @class */ (function () {
    function StorageService() {
    }
    StorageService.prototype.getElementSlugOpened = function (elementId) {
        if (elementId !== '') {
            var storageStatus = localStorage.getItem('admin:element:' + elementId + ':slug:opened');
            return storageStatus === '1';
        }
        return false;
    };
    StorageService.prototype.setElementSlugOpened = function (elementId) {
        if (elementId !== '') {
            localStorage.setItem('admin:element:' + elementId + ':slug:opened', '1');
        }
    };
    StorageService.prototype.setElementSlugClosed = function (elementId) {
        if (elementId !== '') {
            localStorage.removeItem('admin:element:' + elementId + ':slug:opened');
        }
    };
    return StorageService;
}());
exports.StorageService = StorageService;


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

/***/ "components/AjaxLinkManagerCustomAttribute":
/*!**********************************************************!*\
  !*** ./app/components/AjaxLinkManagerCustomAttribute.ts ***!
  \**********************************************************/
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
var AjaxLinkManagerCustomAttribute = /** @class */ (function () {
    function AjaxLinkManagerCustomAttribute(element, templatingEngine, ajaxService) {
        var _this = this;
        this.logger = aurelia_framework_1.LogManager.getLogger('components.AjaxLinkManager');
        this.onDelegateClick = function (evt) {
            if (evt.target) {
                //@ts-ignore
                var currentLink = evt.target.closest('a[data-ajax]');
                if (currentLink && _this.element.contains(currentLink)) {
                    evt.preventDefault();
                    _this.logger.debug('delegateClick');
                    var url = currentLink.href;
                    _this.ajaxService.getRequest(url)
                        .then(function (html) {
                        _this.element.innerHTML = html;
                        /*/
                        this.templatingEngine.enhance({
                            element:this.element,
                            bindingContext: this
                        })
                        /*/
                    });
                }
            }
        };
        this.element = element;
        this.templatingEngine = templatingEngine;
        this.ajaxService = ajaxService;
        this.logger.debug('Constructor');
    }
    AjaxLinkManagerCustomAttribute.prototype.created = function (owningView, myView) {
        this.logger.debug('Created');
    };
    AjaxLinkManagerCustomAttribute.prototype.bind = function (bindingContext, overrideContext) {
        this.logger.debug('Bind');
    };
    AjaxLinkManagerCustomAttribute.prototype.attached = function () {
        this.logger.debug('Attached');
        this.element.addEventListener('click', this.onDelegateClick);
    };
    AjaxLinkManagerCustomAttribute.prototype.detached = function () {
        this.logger.debug('Detached');
        this.element.removeEventListener('click', this.onDelegateClick);
    };
    AjaxLinkManagerCustomAttribute.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    AjaxLinkManagerCustomAttribute = __decorate([
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element, aurelia_framework_1.TemplatingEngine, AjaxService_1.AjaxService)
    ], AjaxLinkManagerCustomAttribute);
    return AjaxLinkManagerCustomAttribute;
}());
exports.AjaxLinkManagerCustomAttribute = AjaxLinkManagerCustomAttribute;


/***/ }),

/***/ "components/AttachModalCustomAttribute":
/*!******************************************************!*\
  !*** ./app/components/AttachModalCustomAttribute.ts ***!
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
var AttachModalCustomAttribute = /** @class */ (function () {
    function AttachModalCustomAttribute(element, ajaxService) {
        var _this = this;
        this.logger = aurelia_framework_1.LogManager.getLogger('components.AttachModal');
        this.ready = false;
        this.readyCount = 0;
        this.onDelegateSubmit = function (evt) {
            if (evt.target) {
                //@ts-ignore
                _this.currentForm = evt.target.closest('form[data-ajax-modal]');
                if (_this.currentForm && _this.element.contains(_this.currentForm)) {
                    evt.preventDefault();
                    var url = _this.currentForm.dataset.ajaxModal;
                    if (url) {
                        _this.ajaxService.getRequest(url)
                            .then(function (modal) {
                            _this.modalView = modal;
                            _this.attachModal();
                        });
                    }
                }
            }
        };
        this.onSubmitOk = function (evt) {
            _this.detachModal();
            _this.currentForm.submit();
        };
        this.onClose = function (evt) {
            _this.detachModal();
        };
        this.element = element;
        this.logger.debug('Constructor');
        this.ajaxService = ajaxService;
    }
    AttachModalCustomAttribute.prototype.created = function (owningView, myView) {
        this.logger.debug('Created');
    };
    AttachModalCustomAttribute.prototype.bind = function (bindingContext, overrideContext) {
        this.logger.debug('Bind');
    };
    AttachModalCustomAttribute.prototype.attached = function () {
        this.logger.debug('Attached');
        this.element.addEventListener('submit', this.onDelegateSubmit);
    };
    AttachModalCustomAttribute.prototype.detached = function () {
        this.element.removeEventListener('submit', this.onDelegateSubmit);
        this.logger.debug('Detached');
    };
    AttachModalCustomAttribute.prototype.attachModal = function () {
        document.body.insertAdjacentHTML('afterbegin', this.modalView);
        this.modal = document.querySelector('#modal-delete');
        this.backdrop = document.querySelector('#modal-delete-backdrop');
        this.modalCross = this.modal.querySelector('#modal-delete-cross');
        this.modalClose = this.modal.querySelector('#modal-delete-close');
        this.modalOk = this.modal.querySelector('#modal-delete-ok');
        this.modalClose.addEventListener('click', this.onClose);
        this.modalCross.addEventListener('click', this.onClose);
        this.modal.addEventListener('click', this.onClose);
        this.modalOk.addEventListener('click', this.onSubmitOk);
    };
    AttachModalCustomAttribute.prototype.detachModal = function () {
        if (this.modalClose) {
            this.modalClose.removeEventListener('click', this.onClose);
        }
        if (this.modalCross) {
            this.modalCross.removeEventListener('click', this.onClose);
        }
        if (this.modalOk) {
            this.modalOk.removeEventListener('click', this.onSubmitOk);
        }
        if (this.modal) {
            this.modal.removeEventListener('click', this.onClose);
            this.modal.remove();
        }
        if (this.backdrop) {
            this.backdrop.remove();
        }
    };
    AttachModalCustomAttribute.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    __decorate([
        aurelia_framework_1.bindable({ primaryProperty: true })
    ], AttachModalCustomAttribute.prototype, "url", void 0);
    AttachModalCustomAttribute = __decorate([
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element, AjaxService_1.AjaxService)
    ], AttachModalCustomAttribute);
    return AttachModalCustomAttribute;
}());
exports.AttachModalCustomAttribute = AttachModalCustomAttribute;


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
    function ManageBlocsCustomAttribute(element, templatingEngine, ajaxService) {
        var _this = this;
        this.logger = aurelia_framework_1.LogManager.getLogger('components.ManageBlocs');
        this.onDelegateClick = function (evt) {
            if (evt.target) {
                //@ts-ignore
                var currentButton = evt.target.closest('button[type=button]');
                if (currentButton && _this.element.contains(currentButton)) {
                    _this.logger.debug('delegateClick');
                    if (currentButton.name) {
                        var formData = new FormData(_this.form);
                        formData.append(currentButton.name, currentButton.value);
                        _this.ajaxService.getBlocs(_this.url, formData)
                            .then(function (response) {
                            if (response.status == 200) {
                                response.text().then(function (text) {
                                    _this.ajaxTarget.innerHTML = text;
                                    _this.templatingEngine.enhance({
                                        element: _this.ajaxTarget,
                                        bindingContext: _this
                                    });
                                });
                            }
                        });
                    }
                }
            }
        };
        this.element = element;
        this.templatingEngine = templatingEngine;
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
        this.ajaxTarget = this.element.querySelector('[data-ajax-target]');
        if (this.ajaxTarget === null) {
            this.ajaxTarget = this.element;
        }
        this.element.addEventListener('click', this.onDelegateClick);
    };
    ManageBlocsCustomAttribute.prototype.detached = function () {
        this.logger.debug('Detached');
        this.element.removeEventListener('click', this.onDelegateClick);
    };
    ManageBlocsCustomAttribute.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    __decorate([
        aurelia_framework_1.bindable({ primaryProperty: true })
    ], ManageBlocsCustomAttribute.prototype, "url", void 0);
    ManageBlocsCustomAttribute = __decorate([
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element, aurelia_framework_1.TemplatingEngine, AjaxService_1.AjaxService)
    ], ManageBlocsCustomAttribute);
    return ManageBlocsCustomAttribute;
}());
exports.ManageBlocsCustomAttribute = ManageBlocsCustomAttribute;


/***/ }),

/***/ "components/ResumableFileCustomElement":
/*!******************************************************!*\
  !*** ./app/components/ResumableFileCustomElement.ts ***!
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
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
var aurelia_framework_1 = __webpack_require__(/*! aurelia-framework */ "aurelia-framework");
var AjaxService_1 = __webpack_require__(/*! ../services/AjaxService */ "./app/services/AjaxService.ts");
var resumablejs_1 = __importDefault(__webpack_require__(/*! resumablejs */ "../../../../node_modules/resumablejs/resumable.js"));
var ResumableFileCustomElement = /** @class */ (function () {
    function ResumableFileCustomElement(element, ajaxService) {
        var _this = this;
        this.logger = aurelia_framework_1.LogManager.getLogger('components.ResumableFile');
        this.multiple = false;
        this.value = '';
        this.onRemove = function (handledFile) {
            _this.logger.debug('Should remove file', handledFile);
            var fileIndex = null;
            _this.handledFiles.forEach(function (file, index) {
                if (handledFile.name === file.name) {
                    fileIndex = index;
                }
            });
            if (fileIndex !== null && fileIndex >= 0) {
                if (handledFile.file && handledFile.file !== null) {
                    _this.resumable.removeFile(handledFile.file);
                }
                _this.handledFiles.splice(fileIndex, 1);
                _this.ajaxService.deleteRequest(handledFile.deleteUrl, _this.csfr.value);
                // should call WS delete
            }
            var fieldValue = _this.getFilesValue();
            _this.hiddenField.value = fieldValue;
        };
        this.onDragEnter = function (evt) {
            evt.preventDefault();
            var el = evt.currentTarget;
            var dt = evt.dataTransfer;
            if (dt && dt.types.indexOf('Files') >= 0) {
                evt.stopPropagation();
                dt.dropEffect = 'copy';
                dt.effectAllowed = 'copy';
                el.classList.add('dragover');
            }
            else if (dt) {
                dt.dropEffect = 'none';
                dt.effectAllowed = 'none';
            }
        };
        this.onDragLeave = function (evt) {
            var el = evt.currentTarget;
            el.classList.remove('dragover');
        };
        this.onFileAdded = function (file, event) {
            _this.logger.debug('onFileAdded', file, event);
            _this.resumable.upload();
        };
        // File upload completed
        this.onFileSuccess = function (file, serverMessage) {
            var response = JSON.parse(serverMessage);
            if (_this.multiple === false) {
                _this.setFile('@blackcubetmp/' + response.finalFilename, file);
            }
            else {
                _this.appendFile('@blackcubetmp/' + response.finalFilename, file);
            }
            _this.logger.debug('onFileSuccess', file, serverMessage);
        };
        // File upload progress
        this.onFileProgress = function (file, serverMessage) {
            _this.logger.debug('onFileProgress', file, serverMessage);
        };
        this.onFilesAdded = function (filesAdded, filesSkipped) {
            _this.logger.debug('onFilesAdded', filesAdded, filesSkipped);
        };
        this.onFileRetry = function (file) {
            _this.logger.debug('onFileRetry', file);
        };
        this.onFileError = function (file, serverMessage) {
            _this.logger.debug('onFileError', file, serverMessage);
        };
        this.onUploadStart = function () {
            _this.logger.debug('onUploadStart');
        };
        this.onComplete = function () {
            _this.logger.debug('onComplete');
        };
        this.onProgress = function () {
            _this.logger.debug('onProgress');
        };
        this.onError = function (serverMessage, file) {
            _this.logger.debug('onError', file, serverMessage);
        };
        this.onPause = function () {
            _this.logger.debug('onPause');
        };
        this.onBeforeCancel = function () {
            _this.logger.debug('onBeforeCancel');
        };
        this.onCancel = function () {
            _this.logger.debug('onCancel');
        };
        this.onChunkingStart = function (file) {
            _this.logger.debug('onChunkingStart', file);
        };
        this.onChunkingProgress = function (file, ratio) {
            _this.logger.debug('onChunkingProgressd', file, ratio);
        };
        this.onChunkingComplete = function (file) {
            _this.logger.debug('onChunkingComplete', file);
        };
        this.element = element;
        this.ajaxService = ajaxService;
        this.logger.debug('Constructor');
    }
    ResumableFileCustomElement.prototype.created = function (owningView, myView) {
        this.logger.debug('Created');
    };
    ResumableFileCustomElement.prototype.bind = function (bindingContext, overrideContext) {
        this.logger.debug('Bind');
    };
    ResumableFileCustomElement.prototype.generatePreviewUrl = function (name) {
        return this.previewUrl.replace('__name__', name);
    };
    ResumableFileCustomElement.prototype.generateDeleteUrl = function (name) {
        return this.deleteUrl.replace('__name__', name);
    };
    ResumableFileCustomElement.prototype.setFiles = function (value) {
        var _this = this;
        var files = value.split(/\s*,\s*/);
        this.handledFiles = files.filter(function (value, index) {
            return value.trim() !== '';
        }).map(function (value, index) {
            return {
                name: value,
                shortname: value.split(/.*[\/|\\]/).pop(),
                previewUrl: _this.generatePreviewUrl(value),
                deleteUrl: _this.generateDeleteUrl(value)
            };
        });
        this.hiddenField.value = this.getFilesValue();
    };
    ResumableFileCustomElement.prototype.setFile = function (name, file) {
        var _this = this;
        if (file === void 0) { file = null; }
        this.handledFiles.forEach(function (handledFile, index) {
            if (handledFile.file && handledFile.file !== null) {
                _this.resumable.removeFile(handledFile.file);
            }
            _this.ajaxService.deleteRequest(handledFile.deleteUrl, _this.csfr.value);
        });
        this.handledFiles = [
            {
                name: name,
                shortname: name.split(/.*[\/|\\]/).pop(),
                previewUrl: this.generatePreviewUrl(name),
                deleteUrl: this.generateDeleteUrl(name),
                file: file
            }
        ];
        this.hiddenField.value = this.getFilesValue();
    };
    ResumableFileCustomElement.prototype.appendFile = function (name, file) {
        if (file === void 0) { file = null; }
        this.handledFiles.push({
            name: name,
            shortname: name.split(/.*[\/|\\]/).pop(),
            previewUrl: this.generatePreviewUrl(name),
            deleteUrl: this.generateDeleteUrl(name),
            file: file
        });
        this.hiddenField.value = this.getFilesValue();
    };
    ResumableFileCustomElement.prototype.getFilesValue = function () {
        var mapped = this.handledFiles.map(function (uploadedFile, index) {
            return uploadedFile.name;
        }).join(', ');
        return (typeof mapped === 'string') ? mapped : '';
    };
    ResumableFileCustomElement.prototype.attached = function () {
        this.parentForm = this.element.closest('form');
        this.logger.debug('Multiple', this.multiple);
        var resumableConfig = {
            target: this.uploadUrl
        };
        if (this.parentForm) {
            var csrfField = this.parentForm.querySelector('input[name=_csrf]');
            this.csfr = {
                name: csrfField.name,
                value: csrfField.value
            };
            resumableConfig.query = {};
            resumableConfig.query[this.csfr.name] = this.csfr.value;
            this.logger.debug('CSRF : ', csrfField.value);
        }
        this.hiddenField = document.createElement('input');
        this.hiddenField.type = 'hidden';
        this.hiddenField.name = this.name;
        this.element.appendChild(this.hiddenField);
        this.setFiles(this.value);
        this.resumable = new resumablejs_1.default(resumableConfig);
        if (this.resumable.support) {
            this.logger.debug('Resume js supported', this.browseButton);
            this.resumable.assignBrowse(this.browseButton, false);
            this.resumable.assignDrop(this.browseButton);
            this.browseButton.addEventListener('dragover', this.onDragEnter);
            this.browseButton.addEventListener('dragenter', this.onDragEnter);
            this.browseButton.addEventListener('dragleave', this.onDragLeave);
            this.browseButton.addEventListener('drop', this.onDragLeave);
            // this.resumable.assignDrop(this.dropTarget);
            this.resumable.on('fileAdded', this.onFileAdded);
            this.resumable.on('fileSuccess', this.onFileSuccess);
            this.resumable.on('fileProgress', this.onFileProgress);
            this.resumable.on('filesAdded', this.onFilesAdded);
            this.resumable.on('fileRetry', this.onFileRetry);
            this.resumable.on('fileError', this.onFileError);
            this.resumable.on('uploadStart', this.onUploadStart);
            this.resumable.on('complete', this.onComplete);
            this.resumable.on('progress', this.onProgress);
            this.resumable.on('error', this.onError);
            this.resumable.on('pause', this.onPause);
            this.resumable.on('beforeCancel', this.onBeforeCancel);
            this.resumable.on('cancel', this.onCancel);
            this.resumable.on('chunkingStart', this.onChunkingStart);
            this.resumable.on('chunkingProgress', this.onChunkingProgress);
            this.resumable.on('chunkingComplete', this.onChunkingComplete);
        }
        this.logger.debug('Attached');
    };
    Object.defineProperty(ResumableFileCustomElement.prototype, "getFiles", {
        get: function () {
            if (this.resumable.support) {
                return this.resumable.files.map(function (file, index) {
                    return file.fileName;
                });
            }
            return [];
        },
        enumerable: true,
        configurable: true
    });
    ResumableFileCustomElement.prototype.detached = function () {
        this.logger.debug('Detached');
    };
    ResumableFileCustomElement.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], ResumableFileCustomElement.prototype, "uploadUrl", void 0);
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], ResumableFileCustomElement.prototype, "previewUrl", void 0);
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], ResumableFileCustomElement.prototype, "deleteUrl", void 0);
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], ResumableFileCustomElement.prototype, "name", void 0);
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], ResumableFileCustomElement.prototype, "multiple", void 0);
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], ResumableFileCustomElement.prototype, "value", void 0);
    ResumableFileCustomElement = __decorate([
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element, AjaxService_1.AjaxService)
    ], ResumableFileCustomElement);
    return ResumableFileCustomElement;
}());
exports.ResumableFileCustomElement = ResumableFileCustomElement;


/***/ }),

/***/ "components/ResumableFileCustomElement.html":
/*!********************************************************!*\
  !*** ./app/components/ResumableFileCustomElement.html ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<template>\n    <!-- div ref=\"dropTarget\" style=\"border:1px solid red; width:200px; height:200px;\"></div -->\n    <button type=\"button\" ref=\"browseButton\" class=\"uploader\">\n        <i class=\"fa fa-cloud-upload-alt\"></i>\n    </button>\n    <ul class=\"w-full\">\n        <li class=\"inline-block text-gray-600 text-center p-2 relative\" repeat.for=\"handledFile of handledFiles\">\n            <button click.delegate=\"onRemove(handledFile)\" class=\"absolute top-0 right-0 rounded-full p-1 text-center bg-white border-gray-600 border h-6 w-6 flex items-center justify-center text-xs\">\n                <i class=\"fa fa-trash-alt\"></i>\n            </button>\n            <img class=\"object-contain h-24\" src.bind=\"handledFile.previewUrl\" title.bind=\"handledFile.shortname\">\n        </li>\n    </ul>\n</template>\n";

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

/***/ "components/ToggleSlugCustomAttribute":
/*!*****************************************************!*\
  !*** ./app/components/ToggleSlugCustomAttribute.ts ***!
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
var StorageService_1 = __webpack_require__(/*! ../services/StorageService */ "./app/services/StorageService.ts");
var ToggleSlugCustomAttribute = /** @class */ (function () {
    function ToggleSlugCustomAttribute(element, eventAggregator, storageService) {
        var _this = this;
        this.logger = aurelia_framework_1.LogManager.getLogger('components.ToggleSlug');
        this.toggleBlocInitialDisplay = 'inherit';
        this.onToggle = function () {
            if (_this.toggleBloc) {
                if (_this.toggleBloc.style.display === 'none') {
                    _this.toggleBloc.style.display = _this.toggleBlocInitialDisplay;
                    _this.storageService.setElementSlugOpened(_this.elementId);
                }
                else {
                    _this.toggleBloc.style.display = 'none';
                    _this.storageService.setElementSlugClosed(_this.elementId);
                }
            }
        };
        this.onChange = function () {
            if (_this.toggleBloc && _this.toggleCheckbox) {
                if (_this.toggleCheckbox.checked) {
                    _this.toggleBloc.style.display = _this.toggleBlocInitialDisplay;
                    _this.storageService.setElementSlugOpened(_this.elementId);
                }
                else {
                    _this.toggleBloc.style.display = 'none';
                    _this.storageService.setElementSlugClosed(_this.elementId);
                }
            }
        };
        this.element = element;
        this.eventAggregator = eventAggregator;
        this.storageService = storageService;
        this.logger.debug('Constructor');
    }
    ToggleSlugCustomAttribute.prototype.created = function (owningView, myView) {
        this.logger.debug('Created');
    };
    ToggleSlugCustomAttribute.prototype.bind = function (bindingContext, overrideContext) {
        this.logger.debug('Bind');
    };
    ToggleSlugCustomAttribute.prototype.attached = function () {
        this.logger.debug('Current ID', this.elementId);
        var opened = this.storageService.getElementSlugOpened(this.elementId);
        this.toggleCheckbox = this.element.querySelector('.toggle');
        this.toggleBloc = this.element.querySelector('.toggle-target');
        this.titleBloc = this.element.firstElementChild;
        if (this.toggleBloc) {
            this.toggleBlocInitialDisplay = this.toggleBloc.style.display;
            if (this.elementId === '' && this.toggleCheckbox) {
                opened = this.toggleCheckbox.checked;
            }
            if (opened === false) {
                this.toggleBloc.style.display = 'none';
            }
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
    ToggleSlugCustomAttribute.prototype.detached = function () {
        this.logger.debug('Detached');
    };
    ToggleSlugCustomAttribute.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    __decorate([
        aurelia_framework_1.bindable({ primaryProperty: true })
    ], ToggleSlugCustomAttribute.prototype, "elementId", void 0);
    ToggleSlugCustomAttribute = __decorate([
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element, aurelia_event_aggregator_1.EventAggregator, StorageService_1.StorageService)
    ], ToggleSlugCustomAttribute);
    return ToggleSlugCustomAttribute;
}());
exports.ToggleSlugCustomAttribute = ToggleSlugCustomAttribute;


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
        'components/ToggleSlugCustomAttribute',
        'components/HtmlLoaderCustomAttribute',
        'components/LoaderDoneCustomAttribute',
        'components/ManageBlocsCustomAttribute',
        'components/AttachModalCustomAttribute',
        'components/AjaxLinkManagerCustomAttribute',
        'components/ResumableFileCustomElement'
    ]);
}
exports.configure = configure;


/***/ })

},[[0,"manifest","aurelia","vendor"]]]);
//# sourceMappingURL=app.js.map