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
    AjaxService.prototype.getRequestJson = function (url) {
        this.logger.debug('getRequestJson', url);
        return this.httpClient.fetch(url, {
            method: 'get',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
            .then(function (response) {
            return response.json();
        });
    };
    AjaxService.prototype.postRequest = function (url, formData) {
        this.logger.debug('postRequest', url);
        return this.httpClient.fetch(url, {
            method: 'post',
            body: formData,
        })
            .then(function (response) {
            return response.text();
        });
    };
    AjaxService.prototype.deleteRequest = function (url, csrf) {
        if (csrf === void 0) { csrf = ''; }
        this.logger.debug('deleteRequest');
        return this.httpClient.fetch(url, { method: 'delete', headers: { 'X-CSRF-Token': csrf } });
    };
    AjaxService.prototype.updateRbac = function (url, formData) {
        this.logger.debug('updateRbac');
        return this.httpClient.fetch(url, {
            method: 'post',
            body: formData
        });
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
    StorageService.prototype.getElementOpened = function (elementType, elementSubData, elementId) {
        if (elementId !== '' && elementSubData !== '' && elementType !== '') {
            var storageStatus = localStorage.getItem('admin:element:' + elementType + '-' + elementId + ':' + elementSubData + ':opened');
            return storageStatus === '1';
        }
        return false;
    };
    StorageService.prototype.setElementOpened = function (elementType, elementSubData, elementId) {
        if (elementId !== '' && elementSubData !== '' && elementType !== '') {
            localStorage.setItem('admin:element:' + elementType + '-' + elementId + ':' + elementSubData + ':opened', '1');
        }
    };
    StorageService.prototype.setElementClosed = function (elementType, elementSubData, elementId) {
        if (elementId !== '' && elementSubData !== '' && elementType !== '') {
            localStorage.removeItem('admin:element:' + elementType + '-' + elementId + ':' + elementSubData + ':opened');
        }
    };
    StorageService.prototype.getSectionOpened = function (elementType, elementId) {
        if (elementId !== '' && elementType !== '') {
            var storageStatus = localStorage.getItem('admin:section:' + elementType + '-' + elementId + ':opened');
            return storageStatus === '1';
        }
        return false;
    };
    StorageService.prototype.setSectionOpened = function (elementType, elementId) {
        if (elementId !== '' && elementType !== '') {
            localStorage.setItem('admin:section:' + elementType + '-' + elementId + ':opened', '1');
        }
    };
    StorageService.prototype.setSectionClosed = function (elementType, elementId) {
        if (elementId !== '' && elementType !== '') {
            localStorage.removeItem('admin:section:' + elementType + '-' + elementId + ':opened');
        }
    };
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

/***/ "components/BlackcubeAjaxifyCustomAttribute":
/*!***********************************************************!*\
  !*** ./app/components/BlackcubeAjaxifyCustomAttribute.ts ***!
  \***********************************************************/
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
var AjaxEvent;
(function (AjaxEvent) {
    AjaxEvent["CLICK"] = "click";
    AjaxEvent["DBLCLICK"] = "dblclick";
    AjaxEvent["INPUT"] = "input";
    AjaxEvent["CHANGE"] = "change";
    AjaxEvent["SUBMIT"] = "submit";
    AjaxEvent["BLUR"] = "blur";
    AjaxEvent["FOCUS"] = "focus";
})(AjaxEvent || (AjaxEvent = {}));
var BlackcubeAjaxifyCustomAttribute = /** @class */ (function () {
    function BlackcubeAjaxifyCustomAttribute(element, templatingEngine, ajaxService) {
        var _this = this;
        this.logger = aurelia_framework_1.LogManager.getLogger('components.BlackcubeAjaxify');
        this.onDelegateEvent = function (event) {
            if (event.target) {
                //@ts-ignore
                var triggerElement = event.target.closest('[data-ajaxify-source]');
                if (triggerElement && _this.element.contains(triggerElement)) {
                    // if we have triggerElement and triggerElement should be handled
                    var currentSource = triggerElement.dataset.ajaxifySource;
                    var targetSelector = null;
                    var targetUrl = null;
                    var targetElement_1 = null;
                    if (currentSource) {
                        targetSelector = '[data-ajaxify-target=' + currentSource + ']';
                    }
                    if (targetSelector !== null) {
                        targetElement_1 = _this.element.querySelector(targetSelector);
                        if (!targetElement_1 && _this.element.dataset.ajaxifyTarget === currentSource) {
                            targetElement_1 = _this.element;
                        }
                    }
                    if (_this.event === AjaxEvent.SUBMIT) {
                        // we should handle the form (post / ...)
                        var elementForm = triggerElement.closest('form');
                        if (elementForm) {
                            if (elementForm.method.toLowerCase() === 'post') {
                                var formData = new FormData(elementForm);
                                if (triggerElement.hasAttribute('name') && triggerElement.hasAttribute('value')) {
                                    //@ts-ignore
                                    formData.append(triggerElement.name, triggerElement.value);
                                }
                                event.preventDefault();
                                _this.ajaxService.postRequest(elementForm.action, formData)
                                    .then(function (html) {
                                    //@ts-ignore
                                    targetElement_1.innerHTML = html;
                                    /**/
                                    _this.templatingEngine.enhance({
                                        //@ts-ignore
                                        element: targetElement_1,
                                        bindingContext: _this
                                    });
                                    /**/
                                })
                                    .catch(function (error) {
                                    _this.logger.warn('Error while submitting URL', error);
                                });
                            }
                            else {
                                _this.logger.warn('Unhandled form method : ', elementForm.method);
                            }
                        }
                        // we should attach modal if needed
                    }
                    else {
                        if (triggerElement && triggerElement.dataset.ajaxifyUrl) {
                            targetUrl = triggerElement.dataset.ajaxifyUrl;
                            //@ts-ignore
                        }
                        else if (triggerElement && triggerElement.href) {
                            //@ts-ignore
                            targetUrl = triggerElement.href;
                        }
                        if (targetUrl !== null) {
                            event.preventDefault();
                            _this.ajaxService.getRequest(targetUrl)
                                .then(function (html) {
                                //@ts-ignore
                                targetElement_1.innerHTML = html;
                                /**/
                                _this.templatingEngine.enhance({
                                    //@ts-ignore
                                    element: targetElement_1,
                                    bindingContext: _this
                                });
                                /**/
                            })
                                .catch(function (error) {
                                _this.logger.warn('Error while requesting URL', error);
                            });
                        }
                        // we should handle a regular request
                    }
                }
            }
        };
        this.element = element;
        this.templatingEngine = templatingEngine;
        this.ajaxService = ajaxService;
        this.logger.debug('Constructor');
    }
    BlackcubeAjaxifyCustomAttribute.prototype.created = function (owningView, myView) {
        this.logger.debug('Created');
    };
    BlackcubeAjaxifyCustomAttribute.prototype.bind = function (bindingContext, overrideContext) {
        this.logger.debug('Bind');
    };
    BlackcubeAjaxifyCustomAttribute.prototype.attached = function () {
        this.logger.debug('Attached');
        this.element.addEventListener(this.event, this.onDelegateEvent);
    };
    BlackcubeAjaxifyCustomAttribute.prototype.detached = function () {
        this.logger.debug('Detached');
        this.element.removeEventListener(this.event, this.onDelegateEvent);
    };
    BlackcubeAjaxifyCustomAttribute.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    __decorate([
        aurelia_framework_1.bindable({ primaryProperty: true })
    ], BlackcubeAjaxifyCustomAttribute.prototype, "event", void 0);
    BlackcubeAjaxifyCustomAttribute = __decorate([
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element, aurelia_framework_1.TemplatingEngine, AjaxService_1.AjaxService)
    ], BlackcubeAjaxifyCustomAttribute);
    return BlackcubeAjaxifyCustomAttribute;
}());
exports.BlackcubeAjaxifyCustomAttribute = BlackcubeAjaxifyCustomAttribute;


/***/ }),

/***/ "components/BlackcubeAttachModalCustomAttribute":
/*!***************************************************************!*\
  !*** ./app/components/BlackcubeAttachModalCustomAttribute.ts ***!
  \***************************************************************/
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
var BlackcubeAttachModalCustomAttribute = /** @class */ (function () {
    function BlackcubeAttachModalCustomAttribute(element, ajaxService) {
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
    BlackcubeAttachModalCustomAttribute.prototype.created = function (owningView, myView) {
        this.logger.debug('Created');
    };
    BlackcubeAttachModalCustomAttribute.prototype.bind = function (bindingContext, overrideContext) {
        this.logger.debug('Bind');
    };
    BlackcubeAttachModalCustomAttribute.prototype.attached = function () {
        this.logger.debug('Attached');
        this.element.addEventListener('submit', this.onDelegateSubmit);
    };
    BlackcubeAttachModalCustomAttribute.prototype.detached = function () {
        this.element.removeEventListener('submit', this.onDelegateSubmit);
        this.logger.debug('Detached');
    };
    BlackcubeAttachModalCustomAttribute.prototype.attachModal = function () {
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
    BlackcubeAttachModalCustomAttribute.prototype.detachModal = function () {
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
    BlackcubeAttachModalCustomAttribute.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    __decorate([
        aurelia_framework_1.bindable({ primaryProperty: true })
    ], BlackcubeAttachModalCustomAttribute.prototype, "url", void 0);
    BlackcubeAttachModalCustomAttribute = __decorate([
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element, AjaxService_1.AjaxService)
    ], BlackcubeAttachModalCustomAttribute);
    return BlackcubeAttachModalCustomAttribute;
}());
exports.BlackcubeAttachModalCustomAttribute = BlackcubeAttachModalCustomAttribute;


/***/ }),

/***/ "components/BlackcubeBlocsCustomAttribute":
/*!*********************************************************!*\
  !*** ./app/components/BlackcubeBlocsCustomAttribute.ts ***!
  \*********************************************************/
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
var BlackcubeBlocsCustomAttribute = /** @class */ (function () {
    function BlackcubeBlocsCustomAttribute(element, templatingEngine, ajaxService) {
        var _this = this;
        this.logger = aurelia_framework_1.LogManager.getLogger('components.ManageBlocs');
        this.onDelegateClick = function (evt) {
            if (evt.target) {
                //TODO: make better delegate
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
    BlackcubeBlocsCustomAttribute.prototype.created = function (owningView, myView) {
        this.logger.debug('Created');
    };
    BlackcubeBlocsCustomAttribute.prototype.bind = function (bindingContext, overrideContext) {
        this.logger.debug('Bind');
    };
    BlackcubeBlocsCustomAttribute.prototype.attached = function () {
        this.logger.debug('Attached');
        this.logger.debug(this.url);
        this.form = this.element.closest('form');
        this.ajaxTarget = this.element.querySelector('[data-ajax-target]');
        if (this.ajaxTarget === null) {
            this.ajaxTarget = this.element;
        }
        this.element.addEventListener('click', this.onDelegateClick);
    };
    BlackcubeBlocsCustomAttribute.prototype.detached = function () {
        this.logger.debug('Detached');
        this.element.removeEventListener('click', this.onDelegateClick);
    };
    BlackcubeBlocsCustomAttribute.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    __decorate([
        aurelia_framework_1.bindable({ primaryProperty: true })
    ], BlackcubeBlocsCustomAttribute.prototype, "url", void 0);
    BlackcubeBlocsCustomAttribute = __decorate([
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element, aurelia_framework_1.TemplatingEngine, AjaxService_1.AjaxService)
    ], BlackcubeBlocsCustomAttribute);
    return BlackcubeBlocsCustomAttribute;
}());
exports.BlackcubeBlocsCustomAttribute = BlackcubeBlocsCustomAttribute;


/***/ }),

/***/ "components/BlackcubeChoicesCustomAttribute":
/*!***********************************************************!*\
  !*** ./app/components/BlackcubeChoicesCustomAttribute.ts ***!
  \***********************************************************/
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
var choices_js_1 = __importDefault(__webpack_require__(/*! choices.js */ "../../../../node_modules/choices.js/public/assets/scripts/choices.js"));
var BlackcubeChoicesCustomAttribute = /** @class */ (function () {
    function BlackcubeChoicesCustomAttribute(element, ajaxService) {
        // @bindable({ primaryProperty: true }) url: string;
        this.logger = aurelia_framework_1.LogManager.getLogger('components.ChoicesManager');
        this.element = element;
        this.logger.debug('Constructor');
        this.ajaxService = ajaxService;
    }
    BlackcubeChoicesCustomAttribute.prototype.created = function (owningView, myView) {
        this.logger.debug('Created');
    };
    BlackcubeChoicesCustomAttribute.prototype.bind = function (bindingContext, overrideContext) {
        this.logger.debug('Bind');
    };
    BlackcubeChoicesCustomAttribute.prototype.attached = function () {
        this.logger.debug('Attached');
        // @ts-ignore
        this.choices = new choices_js_1.default(this.element, {
            removeItemButton: true,
            searchFields: ['label']
        });
    };
    BlackcubeChoicesCustomAttribute.prototype.detached = function () {
        this.logger.debug('Detached');
    };
    BlackcubeChoicesCustomAttribute.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    BlackcubeChoicesCustomAttribute = __decorate([
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element, AjaxService_1.AjaxService)
    ], BlackcubeChoicesCustomAttribute);
    return BlackcubeChoicesCustomAttribute;
}());
exports.BlackcubeChoicesCustomAttribute = BlackcubeChoicesCustomAttribute;


/***/ }),

/***/ "components/BlackcubeCompositesCustomAttribute":
/*!**************************************************************!*\
  !*** ./app/components/BlackcubeCompositesCustomAttribute.ts ***!
  \**************************************************************/
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
var BlackcubeCompositesCustomAttribute = /** @class */ (function () {
    function BlackcubeCompositesCustomAttribute(element, templatingEngine, ajaxService) {
        var _this = this;
        this.logger = aurelia_framework_1.LogManager.getLogger('components.ManageComposites');
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
    BlackcubeCompositesCustomAttribute.prototype.created = function (owningView, myView) {
        this.logger.debug('Created');
    };
    BlackcubeCompositesCustomAttribute.prototype.bind = function (bindingContext, overrideContext) {
        this.logger.debug('Bind');
    };
    BlackcubeCompositesCustomAttribute.prototype.attached = function () {
        this.logger.debug('Attached');
        this.logger.debug(this.url);
        this.form = this.element.closest('form');
        this.ajaxTarget = this.element.querySelector('[data-ajax-target]');
        if (this.ajaxTarget === null) {
            this.ajaxTarget = this.element;
        }
        this.element.addEventListener('click', this.onDelegateClick);
    };
    BlackcubeCompositesCustomAttribute.prototype.detached = function () {
        this.logger.debug('Detached');
        this.element.removeEventListener('click', this.onDelegateClick);
    };
    BlackcubeCompositesCustomAttribute.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    __decorate([
        aurelia_framework_1.bindable({ primaryProperty: true })
    ], BlackcubeCompositesCustomAttribute.prototype, "url", void 0);
    BlackcubeCompositesCustomAttribute = __decorate([
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element, aurelia_framework_1.TemplatingEngine, AjaxService_1.AjaxService)
    ], BlackcubeCompositesCustomAttribute);
    return BlackcubeCompositesCustomAttribute;
}());
exports.BlackcubeCompositesCustomAttribute = BlackcubeCompositesCustomAttribute;


/***/ }),

/***/ "components/BlackcubeControllerActionCustomAttribute":
/*!********************************************************************!*\
  !*** ./app/components/BlackcubeControllerActionCustomAttribute.ts ***!
  \********************************************************************/
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
var BlackcubeControllerActionCustomAttribute = /** @class */ (function () {
    function BlackcubeControllerActionCustomAttribute(element, ajaxService) {
        var _this = this;
        this.logger = aurelia_framework_1.LogManager.getLogger('components.BlackcubeControllerAction');
        this.onChange = function (evt) {
            var select = evt.currentTarget;
            var url = _this.url.replace('__controller__', select.value);
            _this.ajaxService.getRequestJson(url)
                .then(function (body) {
                _this.logger.debug('body');
                var length = _this.targetElement.options.length;
                for (var i = (length - 1); i >= 0; i--) {
                    _this.targetElement.options[i].remove();
                }
                body.forEach(function (value) {
                    var option = document.createElement('option');
                    option.value = value.id;
                    option.label = value.name;
                    if ((select.value === _this.originalSourceValue) && (option.value === _this.originalTargetValue)) {
                        option.selected = true;
                    }
                    _this.targetElement.options.add(option);
                });
            });
            _this.logger.debug('onChange', select.value);
        };
        this.element = element;
        this.ajaxService = ajaxService;
        this.logger.debug('Constructor');
    }
    BlackcubeControllerActionCustomAttribute.prototype.created = function (owningView, myView) {
        this.logger.debug('Created');
    };
    BlackcubeControllerActionCustomAttribute.prototype.bind = function (bindingContext, overrideContext) {
        this.logger.debug('Bind');
    };
    BlackcubeControllerActionCustomAttribute.prototype.attached = function () {
        this.sourceElement = this.element.querySelector('[data-controller-action=source]');
        this.originalSourceValue = this.sourceElement.value;
        this.targetElement = this.element.querySelector('[data-controller-action=target]');
        this.originalTargetValue = this.targetElement.value;
        this.sourceElement.addEventListener('change', this.onChange);
        this.logger.debug('Attached');
    };
    BlackcubeControllerActionCustomAttribute.prototype.detached = function () {
        this.sourceElement.removeEventListener('change', this.onChange);
        this.logger.debug('Detached');
    };
    BlackcubeControllerActionCustomAttribute.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    __decorate([
        aurelia_framework_1.bindable({ primaryProperty: true })
    ], BlackcubeControllerActionCustomAttribute.prototype, "url", void 0);
    BlackcubeControllerActionCustomAttribute = __decorate([
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element, AjaxService_1.AjaxService)
    ], BlackcubeControllerActionCustomAttribute);
    return BlackcubeControllerActionCustomAttribute;
}());
exports.BlackcubeControllerActionCustomAttribute = BlackcubeControllerActionCustomAttribute;


/***/ }),

/***/ "components/BlackcubeEditorJsCustomElement":
/*!**********************************************************!*\
  !*** ./app/components/BlackcubeEditorJsCustomElement.ts ***!
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
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
var aurelia_framework_1 = __webpack_require__(/*! aurelia-framework */ "aurelia-framework");
var editorjs_1 = __importDefault(__webpack_require__(/*! @editorjs/editorjs */ "../../../../node_modules/@editorjs/editorjs/dist/editor.js"));
var header_1 = __importDefault(__webpack_require__(/*! @editorjs/header */ "../../../../node_modules/@editorjs/header/dist/bundle.js"));
var raw_1 = __importDefault(__webpack_require__(/*! @editorjs/raw */ "../../../../node_modules/@editorjs/raw/dist/bundle.js"));
var list_1 = __importDefault(__webpack_require__(/*! @editorjs/list */ "../../../../node_modules/@editorjs/list/dist/bundle.js"));
var quote_1 = __importDefault(__webpack_require__(/*! @editorjs/quote */ "../../../../node_modules/@editorjs/quote/dist/bundle.js"));
var embed_1 = __importDefault(__webpack_require__(/*! @editorjs/embed */ "../../../../node_modules/@editorjs/embed/dist/bundle.js"));
var marker_1 = __importDefault(__webpack_require__(/*! @editorjs/marker */ "../../../../node_modules/@editorjs/marker/dist/bundle.js"));
var paragraph_1 = __importDefault(__webpack_require__(/*! @editorjs/paragraph */ "../../../../node_modules/@editorjs/paragraph/dist/bundle.js"));
var delimiter_1 = __importDefault(__webpack_require__(/*! @editorjs/delimiter */ "../../../../node_modules/@editorjs/delimiter/dist/bundle.js"));
var BlackcubeEditorJsCustomElement = /** @class */ (function () {
    function BlackcubeEditorJsCustomElement(element) {
        var _this = this;
        this.logger = aurelia_framework_1.LogManager.getLogger('components.EditorJs');
        this.onEditorJsChange = function (api) {
            _this.logger.debug('Data changed');
            _this.editorJs.save()
                .then(function (outputData) {
                var jsonData = JSON.stringify(outputData);
                _this.hiddenField.value = jsonData;
            }).catch(function (error) {
                _this.logger.error('save failed');
            });
        };
        this.element = element;
        this.logger.debug('Constructor');
    }
    BlackcubeEditorJsCustomElement.prototype.created = function (owningView, myView) {
        this.logger.debug('Created');
    };
    BlackcubeEditorJsCustomElement.prototype.bind = function (bindingContext, overrideContext) {
        this.logger.debug('Bind');
    };
    BlackcubeEditorJsCustomElement.prototype.attached = function () {
        this.hiddenField.name = this.fieldName;
        this.hiddenField.id = this.fieldId;
        this.hiddenField.value = this.fieldValue;
        this.initEditorJs();
        this.logger.debug('Attached');
    };
    BlackcubeEditorJsCustomElement.prototype.detached = function () {
        this.logger.debug('Detached');
    };
    BlackcubeEditorJsCustomElement.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    BlackcubeEditorJsCustomElement.prototype.initEditorJs = function () {
        var initData = {
            blocks: []
        };
        try {
            initData = JSON.parse(this.hiddenField.value);
        }
        catch (e) {
            this.logger.debug('Data read failed');
        }
        this.editorJs = new editorjs_1.default({
            holder: this.editorContent,
            placeholder: 'Start writing',
            onChange: this.onEditorJsChange,
            minHeight: 50,
            tools: {
                header: {
                    class: header_1.default,
                    config: {
                        placeholder: 'Start to write a header',
                        levels: [1, 2, 3, 4, 5, 6],
                        defaultLevel: 2
                    }
                },
                raw: {
                    class: raw_1.default,
                    config: {
                        placeholder: 'Start to write HTML code'
                    }
                },
                /*/
                code: {
                    class: CodeTool,
                    config: {
                        placeholder: 'Start coding'
                    }
                },
                /**/
                list: {
                    class: list_1.default,
                    inlineToolbar: true,
                    config: {
                        placeholder: 'Start to write your list'
                    }
                },
                quote: {
                    class: quote_1.default,
                    inlineToolbar: true,
                    shortcut: 'CMD+SHIFT+O',
                    config: {
                        quotePlaceholder: 'Start to write a quote',
                        captionPlaceholder: 'Caption'
                    }
                },
                embed: {
                    class: embed_1.default,
                    inlineToolbar: true,
                    config: {
                        services: {
                            youtube: true,
                            vimeo: true
                        }
                    }
                },
                marker: {
                    class: marker_1.default,
                    shortcut: 'CMD+SHIFT+M'
                },
                paragraph: {
                    class: paragraph_1.default,
                    inlineToolbar: true,
                    config: {
                        placeholder: 'Start to write something'
                    }
                },
                delimiter: {
                    class: delimiter_1.default
                }
            },
            data: initData
        });
    };
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], BlackcubeEditorJsCustomElement.prototype, "fieldId", void 0);
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], BlackcubeEditorJsCustomElement.prototype, "fieldName", void 0);
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], BlackcubeEditorJsCustomElement.prototype, "fieldValue", void 0);
    BlackcubeEditorJsCustomElement = __decorate([
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element)
    ], BlackcubeEditorJsCustomElement);
    return BlackcubeEditorJsCustomElement;
}());
exports.BlackcubeEditorJsCustomElement = BlackcubeEditorJsCustomElement;


/***/ }),

/***/ "components/BlackcubeEditorJsCustomElement.html":
/*!************************************************************!*\
  !*** ./app/components/BlackcubeEditorJsCustomElement.html ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<template>\n    <input type=\"hidden\" ref=\"hiddenField\">\n    <div ref=\"editorContent\">\n\n    </div>\n</template>\n";

/***/ }),

/***/ "components/BlackcubeFileCustomElement":
/*!******************************************************!*\
  !*** ./app/components/BlackcubeFileCustomElement.ts ***!
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
var urijs_1 = __importDefault(__webpack_require__(/*! urijs */ "../../../../node_modules/urijs/src/URI.js"));
var BlackcubeFileCustomElement = /** @class */ (function () {
    function BlackcubeFileCustomElement(element, ajaxService) {
        var _this = this;
        this.logger = aurelia_framework_1.LogManager.getLogger('components.BlackcubeFile');
        this.fileType = '';
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
    BlackcubeFileCustomElement.prototype.created = function (owningView, myView) {
        this.logger.debug('Created');
    };
    BlackcubeFileCustomElement.prototype.bind = function (bindingContext, overrideContext) {
        this.logger.debug('Bind');
    };
    BlackcubeFileCustomElement.prototype.appendParametersUrl = function (url) {
        var baseUrl = new urijs_1.default(url);
        if (this.imageWidth) {
            baseUrl.addSearch({ width: this.imageWidth });
        }
        if (this.imageHeight) {
            baseUrl.addSearch({ height: this.imageHeight });
        }
        return baseUrl.toString();
    };
    BlackcubeFileCustomElement.prototype.generatePreviewUrl = function (name) {
        var url = this.previewUrl.replace('__name__', name);
        return this.appendParametersUrl(url);
    };
    BlackcubeFileCustomElement.prototype.generateDeleteUrl = function (name) {
        return this.deleteUrl.replace('__name__', name);
    };
    BlackcubeFileCustomElement.prototype.setFiles = function (value) {
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
    BlackcubeFileCustomElement.prototype.setFile = function (name, file) {
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
    BlackcubeFileCustomElement.prototype.appendFile = function (name, file) {
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
    BlackcubeFileCustomElement.prototype.getFilesValue = function () {
        var mapped = this.handledFiles.map(function (uploadedFile, index) {
            return uploadedFile.name;
        }).join(', ');
        return (typeof mapped === 'string') ? mapped : '';
    };
    BlackcubeFileCustomElement.prototype.attached = function () {
        this.parentForm = this.element.closest('form');
        this.logger.debug('Multiple', this.multiple);
        var resumableConfig = {
            target: this.uploadUrl
        };
        var fileTypes = this.fileType.split(/\s*,\s*/).filter(function (value, index) {
            return value.trim() !== '';
        });
        resumableConfig.fileType = fileTypes;
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
    Object.defineProperty(BlackcubeFileCustomElement.prototype, "getFiles", {
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
    BlackcubeFileCustomElement.prototype.detached = function () {
        this.logger.debug('Detached');
    };
    BlackcubeFileCustomElement.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], BlackcubeFileCustomElement.prototype, "uploadUrl", void 0);
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], BlackcubeFileCustomElement.prototype, "previewUrl", void 0);
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], BlackcubeFileCustomElement.prototype, "deleteUrl", void 0);
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], BlackcubeFileCustomElement.prototype, "fileType", void 0);
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], BlackcubeFileCustomElement.prototype, "name", void 0);
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], BlackcubeFileCustomElement.prototype, "multiple", void 0);
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], BlackcubeFileCustomElement.prototype, "value", void 0);
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], BlackcubeFileCustomElement.prototype, "imageWidth", void 0);
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], BlackcubeFileCustomElement.prototype, "imageHeight", void 0);
    BlackcubeFileCustomElement = __decorate([
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element, AjaxService_1.AjaxService)
    ], BlackcubeFileCustomElement);
    return BlackcubeFileCustomElement;
}());
exports.BlackcubeFileCustomElement = BlackcubeFileCustomElement;


/***/ }),

/***/ "components/BlackcubeFileCustomElement.html":
/*!********************************************************!*\
  !*** ./app/components/BlackcubeFileCustomElement.html ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<template>\n    <!-- div ref=\"dropTarget\" style=\"border:1px solid red; width:200px; height:200px;\"></div -->\n    <button type=\"button\" ref=\"browseButton\" class=\"uploader\">\n        <i class=\"fa fa-cloud-upload-alt\"></i>\n    </button>\n    <ul class=\"w-full\">\n        <li class=\"inline-block text-gray-600 text-center p-2 relative\" repeat.for=\"handledFile of handledFiles\">\n            <button click.delegate=\"onRemove(handledFile)\" class=\"absolute top-0 right-0 rounded-full p-1 text-center bg-white border-gray-600 border h-6 w-6 flex items-center justify-center text-xs\">\n                <i class=\"fa fa-trash-alt\"></i>\n            </button>\n            <img class=\"object-contain h-24\" src.bind=\"handledFile.previewUrl\" title.bind=\"handledFile.shortname\">\n        </li>\n    </ul>\n</template>\n";

/***/ }),

/***/ "components/BlackcubePieCustomElement":
/*!*****************************************************!*\
  !*** ./app/components/BlackcubePieCustomElement.ts ***!
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
var __importStar = (this && this.__importStar) || function (mod) {
    if (mod && mod.__esModule) return mod;
    var result = {};
    if (mod != null) for (var k in mod) if (Object.hasOwnProperty.call(mod, k)) result[k] = mod[k];
    result["default"] = mod;
    return result;
};
Object.defineProperty(exports, "__esModule", { value: true });
var aurelia_framework_1 = __webpack_require__(/*! aurelia-framework */ "aurelia-framework");
var Chartist = __importStar(__webpack_require__(/*! chartist */ "../../../../node_modules/chartist/dist/chartist.js"));
var BlackcubePieCustomElement = /** @class */ (function () {
    function BlackcubePieCustomElement(element) {
        this.logger = aurelia_framework_1.LogManager.getLogger('components.ChartistPie');
        this.inactive = 0;
        this.activeUrl = 0;
        this.activeNoUrl = 0;
        this.inactiveLabel = 'Inactive';
        this.activeUrlLabel = 'Active';
        this.activeNoUrlLabel = 'Active No URL';
        this.element = element;
        this.logger.debug('Constructor');
    }
    BlackcubePieCustomElement.prototype.created = function (owningView, myView) {
        this.logger.debug('Created');
    };
    BlackcubePieCustomElement.prototype.bind = function (bindingContext, overrideContext) {
        this.logger.debug('Bind');
    };
    BlackcubePieCustomElement.prototype.attached = function () {
        this.chart = new Chartist.Pie(this.element, {
            labels: [this.activeUrlLabel, this.inactiveLabel, this.activeNoUrlLabel],
            series: [{
                    value: this.activeUrl,
                    name: this.activeUrlLabel,
                    className: 'active-url',
                    meta: 'Meta One'
                }, {
                    value: this.inactive,
                    name: this.inactiveLabel,
                    className: 'inactive',
                    meta: 'Meta Two'
                }, {
                    value: this.activeNoUrl,
                    name: this.activeNoUrlLabel,
                    className: 'active-no-url',
                    meta: 'Meta Three'
                }]
        }, {
            width: '250px',
            height: '250px',
            donut: true,
            labelOffset: -50,
            donutWidth: 30,
            donutSolid: true,
            startAngle: 270,
            showLabel: true,
            ignoreEmptyValues: true
            // labelPosition: 'outside'
        });
        this.logger.debug('Attached');
    };
    BlackcubePieCustomElement.prototype.detached = function () {
        this.logger.debug('Detached');
    };
    BlackcubePieCustomElement.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], BlackcubePieCustomElement.prototype, "inactive", void 0);
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], BlackcubePieCustomElement.prototype, "activeUrl", void 0);
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], BlackcubePieCustomElement.prototype, "activeNoUrl", void 0);
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], BlackcubePieCustomElement.prototype, "inactiveLabel", void 0);
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], BlackcubePieCustomElement.prototype, "activeUrlLabel", void 0);
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], BlackcubePieCustomElement.prototype, "activeNoUrlLabel", void 0);
    BlackcubePieCustomElement = __decorate([
        aurelia_framework_1.noView(),
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element)
    ], BlackcubePieCustomElement);
    return BlackcubePieCustomElement;
}());
exports.BlackcubePieCustomElement = BlackcubePieCustomElement;


/***/ }),

/***/ "components/BlackcubeRbacCustomAttribute":
/*!********************************************************!*\
  !*** ./app/components/BlackcubeRbacCustomAttribute.ts ***!
  \********************************************************/
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
var BlackcubeRbacCustomAttribute = /** @class */ (function () {
    function BlackcubeRbacCustomAttribute(element, ajaxService) {
        var _this = this;
        this.logger = aurelia_framework_1.LogManager.getLogger('components.BlackcubeRbac');
        this.onDelegateChange = function (event) {
            if (event.target) {
                //@ts-ignore
                var currentCheckbox = event.target.closest('input[type=checkbox]');
                if (currentCheckbox && _this.element.contains(currentCheckbox)) {
                    _this.logger.debug('delegateClick', currentCheckbox.dataset);
                    var formData = new FormData();
                    if ('rbacType' in currentCheckbox.dataset) {
                        //@ts-ignore
                        formData.append('type', currentCheckbox.dataset.rbacType);
                    }
                    if ('rbacName' in currentCheckbox.dataset) {
                        //@ts-ignore
                        formData.append('name', currentCheckbox.dataset.rbacName);
                    }
                    formData.append('mode', currentCheckbox.checked ? 'add' : 'remove');
                    formData.append(_this.csrf.name, _this.csrf.value);
                    // formData.append()
                    _this.ajaxService.updateRbac(_this.targetUrl, formData)
                        .then(function (response) {
                        return response.text();
                    })
                        .then(function (html) {
                        _this.element.innerHTML = html;
                    });
                }
            }
        };
        this.element = element;
        this.ajaxService = ajaxService;
        this.logger.debug('Constructor');
    }
    BlackcubeRbacCustomAttribute.prototype.created = function (owningView, myView) {
        this.logger.debug('Created');
    };
    BlackcubeRbacCustomAttribute.prototype.bind = function (bindingContext, overrideContext) {
        this.logger.debug('Bind');
    };
    BlackcubeRbacCustomAttribute.prototype.attached = function () {
        var parentForm = this.element.closest('form');
        var csrfField = parentForm.querySelector('input[name=_csrf]');
        this.csrf = {
            name: csrfField.name,
            value: csrfField.value
        };
        this.element.addEventListener('change', this.onDelegateChange);
        this.logger.debug('Attached');
    };
    BlackcubeRbacCustomAttribute.prototype.detached = function () {
        this.element.removeEventListener('change', this.onDelegateChange);
        this.logger.debug('Detached');
    };
    BlackcubeRbacCustomAttribute.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    __decorate([
        aurelia_framework_1.bindable({ primaryProperty: true })
    ], BlackcubeRbacCustomAttribute.prototype, "targetUrl", void 0);
    BlackcubeRbacCustomAttribute = __decorate([
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element, AjaxService_1.AjaxService)
    ], BlackcubeRbacCustomAttribute);
    return BlackcubeRbacCustomAttribute;
}());
exports.BlackcubeRbacCustomAttribute = BlackcubeRbacCustomAttribute;


/***/ }),

/***/ "components/BlackcubeSchemaEditorCustomElement":
/*!**************************************************************!*\
  !*** ./app/components/BlackcubeSchemaEditorCustomElement.ts ***!
  \**************************************************************/
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
var BlackcubeSchemaEditorCustomElement = /** @class */ (function () {
    function BlackcubeSchemaEditorCustomElement(element) {
        this.logger = aurelia_framework_1.LogManager.getLogger('components.SchemaEditor');
        this.element = element;
        this.logger.debug('Constructor');
    }
    BlackcubeSchemaEditorCustomElement.prototype.created = function (owningView, myView) {
        this.logger.debug('Created');
    };
    BlackcubeSchemaEditorCustomElement.prototype.bind = function (bindingContext, overrideContext) {
        this.logger.debug('Bind');
    };
    BlackcubeSchemaEditorCustomElement.prototype.attached = function () {
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
    BlackcubeSchemaEditorCustomElement.prototype.detached = function () {
        this.logger.debug('Detached');
    };
    BlackcubeSchemaEditorCustomElement.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    BlackcubeSchemaEditorCustomElement.prototype.buildEditor = function () {
        var _this = this;
        var config = {
            mode: "tree",
            search: false,
            navigationBar: false,
            statusBar: false,
            mainMenuBar: false,
            language: "en",
            templates: [
                {
                    text: 'Email',
                    title: 'Insert Email property',
                    className: 'jsoneditor-type-object',
                    value: {
                        type: 'string',
                        format: 'email',
                        minLength: 6,
                        description: 'Email'
                    }
                },
                {
                    text: 'Regexp',
                    title: 'Insert Regexp property',
                    className: 'jsoneditor-type-object',
                    value: {
                        type: 'string',
                        pattern: '^[a-z0-9]+$',
                        minLength: 6,
                        description: 'Email'
                    }
                },
                {
                    text: 'Image',
                    title: 'Insert Image property',
                    className: 'jsoneditor-type-object',
                    value: {
                        type: 'string',
                        format: 'file',
                        fileType: 'png,jpg',
                        imageWidth: 600,
                        imageHeight: 200,
                        description: 'Image size should be 600x200'
                    }
                },
                {
                    text: 'Wysiwyg',
                    title: 'Insert Wysiwyg property',
                    className: 'jsoneditor-type-object',
                    value: {
                        type: 'string',
                        format: 'wysiwyg',
                        description: 'Wysiwyg Editor'
                    }
                }
            ]
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
    ], BlackcubeSchemaEditorCustomElement.prototype, "fieldId", void 0);
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], BlackcubeSchemaEditorCustomElement.prototype, "fieldName", void 0);
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], BlackcubeSchemaEditorCustomElement.prototype, "schema", void 0);
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], BlackcubeSchemaEditorCustomElement.prototype, "language", void 0);
    BlackcubeSchemaEditorCustomElement = __decorate([
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element)
    ], BlackcubeSchemaEditorCustomElement);
    return BlackcubeSchemaEditorCustomElement;
}());
exports.BlackcubeSchemaEditorCustomElement = BlackcubeSchemaEditorCustomElement;


/***/ }),

/***/ "components/BlackcubeSchemaEditorCustomElement.html":
/*!****************************************************************!*\
  !*** ./app/components/BlackcubeSchemaEditorCustomElement.html ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<template>\n    <input type=\"hidden\" />\n    <div></div>\n</template>\n";

/***/ }),

/***/ "components/BlackcubeSearchCompositeCustomElement":
/*!*****************************************************************!*\
  !*** ./app/components/BlackcubeSearchCompositeCustomElement.ts ***!
  \*****************************************************************/
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
var BlackcubeSearchCompositeCustomElement = /** @class */ (function () {
    function BlackcubeSearchCompositeCustomElement(element, ajaxService) {
        var _this = this;
        this.logger = aurelia_framework_1.LogManager.getLogger('components.SearchComposite');
        this.composites = [];
        this.onInput = function (event) {
            _this.compositeAdd.value = '';
            // if (this.search.value.trim() === '') {
            // this.composites = [];
            // } else {
            _this.ajaxService.getRequestJson(_this.buildSearchQuery(_this.search.value))
                .then(function (composites) {
                _this.composites = composites;
                /*/
                if (composites.length === 1) {
                    this.onChoose(composites[0].id, composites[0].name);
                }
                /**/
            });
            // }
        };
        this.element = element;
        this.ajaxService = ajaxService;
        this.logger.debug('Constructor');
    }
    BlackcubeSearchCompositeCustomElement.prototype.created = function (owningView, myView) {
        this.logger.debug('Created');
    };
    BlackcubeSearchCompositeCustomElement.prototype.bind = function (bindingContext, overrideContext) {
        this.logger.debug('Bind');
    };
    BlackcubeSearchCompositeCustomElement.prototype.attached = function () {
        this.search.addEventListener('focus', this.onInput);
        this.logger.debug('Attached');
    };
    BlackcubeSearchCompositeCustomElement.prototype.detached = function () {
        this.search.removeEventListener('focus', this.onInput);
        this.logger.debug('Detached');
    };
    BlackcubeSearchCompositeCustomElement.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    BlackcubeSearchCompositeCustomElement.prototype.onClick = function () {
        this.logger.debug('Submit sent');
        this.search.value = '';
    };
    BlackcubeSearchCompositeCustomElement.prototype.buildSearchQuery = function (search) {
        return this.searchUrl.replace('__query__', search);
    };
    BlackcubeSearchCompositeCustomElement.prototype.onChoose = function (id, value) {
        //@ts-ignore
        this.compositeAdd.value = id;
        this.search.value = value;
        this.composites = [];
    };
    __decorate([
        aurelia_framework_1.bindable({ defaultBindingMode: aurelia_framework_1.bindingMode.fromView })
    ], BlackcubeSearchCompositeCustomElement.prototype, "searchUrl", void 0);
    BlackcubeSearchCompositeCustomElement = __decorate([
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element, AjaxService_1.AjaxService)
    ], BlackcubeSearchCompositeCustomElement);
    return BlackcubeSearchCompositeCustomElement;
}());
exports.BlackcubeSearchCompositeCustomElement = BlackcubeSearchCompositeCustomElement;


/***/ }),

/***/ "components/BlackcubeSearchCompositeCustomElement.html":
/*!*******************************************************************!*\
  !*** ./app/components/BlackcubeSearchCompositeCustomElement.html ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<template>\n    <div class=\"bloc bloc-tools relative\">\n        <input type=\"text\" ref=\"search\" input.delegate=\"onInput($event) & debounce:500\" class=\"border-l border-t border-b border-gray-300 rounded-l outline-none ml-2 p-2\">\n        <button type=\"button\" ref=\"compositeAdd\" click.delegate=\"onClick()\" name=\"compositeAdd\" class=\"button\">\n            <svg class=\"fill-current h-4 w-4\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" >\n                <path d=\"M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2zm0 2v14h14V5H5zm8 6h2a1 1 0 0 1 0 2h-2v2a1 1 0 0 1-2 0v-2H9a1 1 0 0 1 0-2h2V9a1 1 0 0 1 2 0v2z\"/>\n            </svg>\n        </button>\n        <ul show.bind=\"composites.length > 0\" class=\"absolute z-10 bg-gray-200 w-2/3 text-xs p-1 rounded\" style=\"top:3em;right:1em;\">\n            <li repeat.for=\"composite of composites\" click.delegate=\"onChoose(composite.id, composite.name)\" class=\"border-b border-white rounded hover:bg-blue-800 hover:text-white p-1 cursor-pointer\">\n                ${composite.name}\n            </li>\n        </ul>\n    </div>\n</template>\n";

/***/ }),

/***/ "components/BlackcubeSidebarCustomAttribute":
/*!***********************************************************!*\
  !*** ./app/components/BlackcubeSidebarCustomAttribute.ts ***!
  \***********************************************************/
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
var StorageService_1 = __webpack_require__(/*! ../services/StorageService */ "./app/services/StorageService.ts");
var BlackcubeSidebarCustomAttribute = /** @class */ (function () {
    function BlackcubeSidebarCustomAttribute(element, storageService) {
        var _this = this;
        this.logger = aurelia_framework_1.LogManager.getLogger('components.BlackcubeSidebar');
        this.onDelegateClick = function (evt) {
            if (evt.target) {
                //@ts-ignore
                var currentButton = evt.target.closest('[data-blackcube-section]');
                if (currentButton && _this.element.contains(currentButton)) {
                    _this.logger.debug('delegateClick');
                    var currentSection = currentButton.dataset.blackcubeSection;
                    if (currentSection) {
                        var opened = _this.storageService.getSectionOpened('menu', currentSection);
                        var nexNode = currentButton.nextElementSibling;
                        var arrow = currentButton.querySelector('i.arrow');
                        if (opened) {
                            _this.storageService.setSectionClosed('menu', currentSection);
                            if (nexNode) {
                                nexNode.classList.add('hidden');
                            }
                            if (arrow) {
                                arrow.classList.remove('fa-angle-down');
                                arrow.classList.add('fa-angle-right');
                            }
                        }
                        else if (nexNode) {
                            _this.storageService.setSectionOpened('menu', currentSection);
                            nexNode.classList.remove('hidden');
                            if (arrow) {
                                arrow.classList.remove('fa-angle-right');
                                arrow.classList.add('fa-angle-down');
                            }
                        }
                    }
                }
            }
        };
        this.element = element;
        this.storageService = storageService;
        this.logger.debug('Constructor');
    }
    BlackcubeSidebarCustomAttribute.prototype.created = function (owningView, myView) {
        this.logger.debug('Created');
    };
    BlackcubeSidebarCustomAttribute.prototype.bind = function (bindingContext, overrideContext) {
        this.logger.debug('Bind');
    };
    BlackcubeSidebarCustomAttribute.prototype.attached = function () {
        var _this = this;
        var currentSections = this.element.querySelectorAll('[data-blackcube-section]');
        currentSections.forEach(function (element) {
            var currentSection = element.dataset.blackcubeSection;
            if (currentSection) {
                var opened = _this.storageService.getSectionOpened('menu', currentSection);
                var nexNode = element.nextElementSibling;
                var arrow = element.querySelector('i.arrow');
                if (opened) {
                    if (nexNode) {
                        nexNode.classList.remove('hidden');
                    }
                    if (arrow) {
                        arrow.classList.remove('fa-angle-right');
                        arrow.classList.add('fa-angle-down');
                    }
                }
                else if (nexNode) {
                    nexNode.classList.add('hidden');
                    if (arrow) {
                        arrow.classList.remove('fa-angle-down');
                        arrow.classList.add('fa-angle-right');
                    }
                }
            }
        });
        this.element.addEventListener('click', this.onDelegateClick);
        this.logger.debug('Attached');
    };
    BlackcubeSidebarCustomAttribute.prototype.detached = function () {
        this.element.removeEventListener('click', this.onDelegateClick);
        this.logger.debug('Detached');
    };
    BlackcubeSidebarCustomAttribute.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    BlackcubeSidebarCustomAttribute = __decorate([
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element, StorageService_1.StorageService)
    ], BlackcubeSidebarCustomAttribute);
    return BlackcubeSidebarCustomAttribute;
}());
exports.BlackcubeSidebarCustomAttribute = BlackcubeSidebarCustomAttribute;


/***/ }),

/***/ "components/BlackcubeToggleDependenciesCustomAttribute":
/*!**********************************************************************!*\
  !*** ./app/components/BlackcubeToggleDependenciesCustomAttribute.ts ***!
  \**********************************************************************/
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
var BlackcubeToggleDependenciesCustomAttribute = /** @class */ (function () {
    function BlackcubeToggleDependenciesCustomAttribute(element) {
        var _this = this;
        this.logger = aurelia_framework_1.LogManager.getLogger('components.ToggleDependencies');
        this.onChange = function (item) {
            var toggle = item.currentTarget;
            if (toggle.checked) {
                _this.activeFields();
            }
            else {
                _this.deactivateFields();
            }
        };
        this.element = element;
        this.logger.debug('Constructor');
    }
    BlackcubeToggleDependenciesCustomAttribute.prototype.created = function (owningView, myView) {
        this.logger.debug('Created');
    };
    BlackcubeToggleDependenciesCustomAttribute.prototype.bind = function (bindingContext, overrideContext) {
        this.logger.debug('Bind');
    };
    BlackcubeToggleDependenciesCustomAttribute.prototype.attached = function () {
        if (this.targetFilter.trim() == '') {
            this.targetFilter = '[data-dependency]';
        }
        this.toggleCheckbox = this.element.querySelector('input[type=checkbox]');
        this.toggleTargets = this.element.querySelectorAll(this.targetFilter);
        this.deactivateFields();
        if (this.toggleCheckbox) {
            this.toggleCheckbox.addEventListener('change', this.onChange);
        }
        this.logger.debug('Attached', this.targetFilter);
    };
    BlackcubeToggleDependenciesCustomAttribute.prototype.detached = function () {
        if (this.toggleCheckbox) {
            this.toggleCheckbox.removeEventListener('change', this.onChange);
        }
        this.logger.debug('Detached');
    };
    BlackcubeToggleDependenciesCustomAttribute.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    BlackcubeToggleDependenciesCustomAttribute.prototype.activeFields = function () {
        this.toggleTargets.forEach(function (item) {
            if (item.classList.contains('opacity-50')) {
                item.classList.remove('opacity-50');
            }
            item.querySelectorAll('input, select').forEach(function (item) {
                item.disabled = false;
            });
        });
    };
    BlackcubeToggleDependenciesCustomAttribute.prototype.deactivateFields = function () {
        this.toggleTargets.forEach(function (item) {
            if (!item.classList.contains('opacity-50')) {
                item.classList.add('opacity-50');
            }
            item.querySelectorAll('input, select').forEach(function (item) {
                item.disabled = true;
            });
        });
    };
    __decorate([
        aurelia_framework_1.bindable({ primaryProperty: true })
    ], BlackcubeToggleDependenciesCustomAttribute.prototype, "targetFilter", void 0);
    BlackcubeToggleDependenciesCustomAttribute = __decorate([
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element)
    ], BlackcubeToggleDependenciesCustomAttribute);
    return BlackcubeToggleDependenciesCustomAttribute;
}());
exports.BlackcubeToggleDependenciesCustomAttribute = BlackcubeToggleDependenciesCustomAttribute;


/***/ }),

/***/ "components/BlackcubeToggleElementCustomAttribute":
/*!*****************************************************************!*\
  !*** ./app/components/BlackcubeToggleElementCustomAttribute.ts ***!
  \*****************************************************************/
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
var StorageService_1 = __webpack_require__(/*! ../services/StorageService */ "./app/services/StorageService.ts");
var BlackcubeToggleElementCustomAttribute = /** @class */ (function () {
    function BlackcubeToggleElementCustomAttribute(element, storageService) {
        var _this = this;
        this.logger = aurelia_framework_1.LogManager.getLogger('components.BlackcubeToggleData');
        this.onDelegateClick = function (evt) {
            if (evt.target) {
                //@ts-ignore
                var currentButton = evt.target.closest('[data-toggle-element=source]');
                if (currentButton && _this.element.contains(currentButton)) {
                    _this.logger.debug('delegateClick');
                    var open_1 = _this.storageService.getElementOpened(_this.elementType, _this.elementSubData, _this.elementId);
                    if (open_1) {
                        _this.hideTargets(currentButton);
                        _this.storageService.setElementClosed(_this.elementType, _this.elementSubData, _this.elementId);
                    }
                    else {
                        _this.showTargets(currentButton);
                        _this.storageService.setElementOpened(_this.elementType, _this.elementSubData, _this.elementId);
                    }
                }
            }
        };
        this.element = element;
        this.storageService = storageService;
        this.logger.debug('Constructor');
    }
    BlackcubeToggleElementCustomAttribute.prototype.created = function (owningView, myView) {
        this.logger.debug('Created');
    };
    BlackcubeToggleElementCustomAttribute.prototype.bind = function (bindingContext, overrideContext) {
        this.logger.debug('Bind');
    };
    BlackcubeToggleElementCustomAttribute.prototype.attached = function () {
        this.logger.debug('Current ID', this.elementId);
        //TODO: should delegate
        var opened = this.storageService.getElementOpened(this.elementType, this.elementSubData, this.elementId);
        var currentButton = this.element.querySelector('[data-toggle-element=source]');
        this.showHideTargets = this.element.querySelectorAll('[data-toggle-element=target]');
        if (opened) {
            this.showTargets(currentButton);
            // this.titleBloc.addEventListener('click', this.onToggle);
        }
        else {
            this.hideTargets(currentButton);
        }
        this.element.addEventListener('click', this.onDelegateClick);
        this.logger.debug('Attached');
    };
    BlackcubeToggleElementCustomAttribute.prototype.detached = function () {
        this.logger.debug('Detached');
    };
    BlackcubeToggleElementCustomAttribute.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    BlackcubeToggleElementCustomAttribute.prototype.showTargets = function (button) {
        this.showHideTargets.forEach(function (item) {
            if (item.classList.contains('hidden')) {
                item.classList.remove('hidden');
            }
        });
        if (button) {
            var icon = button.querySelector('.fa');
            if (icon) {
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            }
        }
    };
    BlackcubeToggleElementCustomAttribute.prototype.hideTargets = function (button) {
        this.showHideTargets.forEach(function (item) {
            if (!item.classList.contains('hidden')) {
                item.classList.add('hidden');
            }
        });
        if (button) {
            var icon = button.querySelector('.fa');
            if (icon) {
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
        }
    };
    __decorate([
        aurelia_framework_1.bindable()
    ], BlackcubeToggleElementCustomAttribute.prototype, "elementId", void 0);
    __decorate([
        aurelia_framework_1.bindable()
    ], BlackcubeToggleElementCustomAttribute.prototype, "elementType", void 0);
    __decorate([
        aurelia_framework_1.bindable()
    ], BlackcubeToggleElementCustomAttribute.prototype, "elementSubData", void 0);
    BlackcubeToggleElementCustomAttribute = __decorate([
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element, StorageService_1.StorageService)
    ], BlackcubeToggleElementCustomAttribute);
    return BlackcubeToggleElementCustomAttribute;
}());
exports.BlackcubeToggleElementCustomAttribute = BlackcubeToggleElementCustomAttribute;


/***/ }),

/***/ "components/BlackcubeToggleSlugCustomAttribute":
/*!**************************************************************!*\
  !*** ./app/components/BlackcubeToggleSlugCustomAttribute.ts ***!
  \**************************************************************/
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
var BlackcubeToggleSlugCustomAttribute = /** @class */ (function () {
    function BlackcubeToggleSlugCustomAttribute(element, eventAggregator, storageService) {
        var _this = this;
        this.logger = aurelia_framework_1.LogManager.getLogger('components.ToggleSlug');
        this.toggleBlocInitialDisplay = 'inherit';
        this.onToggle = function () {
            if (_this.toggleBloc && _this.toggleCheckbox && _this.toggleCheckbox.checked) {
                if (_this.toggleBloc.classList.contains('hidden')) {
                    _this.toggleBloc.classList.remove('hidden');
                    if (_this.titleBloc) {
                        var icon = _this.titleBloc.querySelector('.fa');
                        if (icon) {
                            icon.classList.remove('fa-chevron-down');
                            icon.classList.add('fa-chevron-up');
                        }
                    }
                    _this.storageService.setElementSlugOpened(_this.elementId);
                }
                else {
                    _this.toggleBloc.classList.add('hidden');
                    if (_this.titleBloc) {
                        var icon = _this.titleBloc.querySelector('.fa');
                        if (icon) {
                            icon.classList.remove('fa-chevron-up');
                            icon.classList.add('fa-chevron-down');
                        }
                    }
                    _this.storageService.setElementSlugClosed(_this.elementId);
                }
            }
        };
        this.onChange = function () {
            if (_this.toggleBloc && _this.toggleCheckbox) {
                if (_this.toggleCheckbox.checked) {
                    _this.toggleBloc.classList.remove('hidden');
                    if (_this.titleBloc) {
                        var icon = _this.titleBloc.querySelector('.fa');
                        if (icon) {
                            icon.classList.remove('fa-chevron-down');
                            icon.classList.add('fa-chevron-up');
                        }
                    }
                    _this.storageService.setElementSlugOpened(_this.elementId);
                }
                else {
                    _this.toggleBloc.classList.add('hidden');
                    if (_this.titleBloc) {
                        var icon = _this.titleBloc.querySelector('.fa');
                        if (icon) {
                            icon.classList.remove('fa-chevron-up');
                            icon.classList.add('fa-chevron-down');
                        }
                    }
                    _this.storageService.setElementSlugClosed(_this.elementId);
                }
            }
        };
        this.element = element;
        this.eventAggregator = eventAggregator;
        this.storageService = storageService;
        this.logger.debug('Constructor');
    }
    BlackcubeToggleSlugCustomAttribute.prototype.created = function (owningView, myView) {
        this.logger.debug('Created');
    };
    BlackcubeToggleSlugCustomAttribute.prototype.bind = function (bindingContext, overrideContext) {
        this.logger.debug('Bind');
    };
    BlackcubeToggleSlugCustomAttribute.prototype.attached = function () {
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
                this.toggleBloc.classList.add('hidden');
            }
            else {
                this.toggleBloc.classList.remove('hidden');
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
    BlackcubeToggleSlugCustomAttribute.prototype.detached = function () {
        this.logger.debug('Detached');
    };
    BlackcubeToggleSlugCustomAttribute.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    __decorate([
        aurelia_framework_1.bindable({ primaryProperty: true })
    ], BlackcubeToggleSlugCustomAttribute.prototype, "elementId", void 0);
    BlackcubeToggleSlugCustomAttribute = __decorate([
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element, aurelia_event_aggregator_1.EventAggregator, StorageService_1.StorageService)
    ], BlackcubeToggleSlugCustomAttribute);
    return BlackcubeToggleSlugCustomAttribute;
}());
exports.BlackcubeToggleSlugCustomAttribute = BlackcubeToggleSlugCustomAttribute;


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
        'components/BlackcubeSchemaEditorCustomElement',
        'components/BlackcubeToggleSlugCustomAttribute',
        'components/BlackcubeBlocsCustomAttribute',
        'components/BlackcubeCompositesCustomAttribute',
        'components/BlackcubeAttachModalCustomAttribute',
        'components/BlackcubeFileCustomElement',
        'components/BlackcubeChoicesCustomAttribute',
        'components/BlackcubePieCustomElement',
        'components/BlackcubeControllerActionCustomAttribute',
        'components/BlackcubeToggleDependenciesCustomAttribute',
        'components/BlackcubeToggleElementCustomAttribute',
        'components/BlackcubeSearchCompositeCustomElement',
        'components/BlackcubeRbacCustomAttribute',
        'components/BlackcubeSidebarCustomAttribute',
        'components/BlackcubeEditorJsCustomElement',
        'components/BlackcubeAjaxifyCustomAttribute'
    ]);
}
exports.configure = configure;


/***/ })

},[[0,"manifest","aurelia","vendor"]]]);
//# sourceMappingURL=app.js.map