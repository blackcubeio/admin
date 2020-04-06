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

/***/ "components/BlackcubeAjaxLinkCustomAttribute":
/*!************************************************************!*\
  !*** ./app/components/BlackcubeAjaxLinkCustomAttribute.ts ***!
  \************************************************************/
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
var BlackcubeAjaxLinkCustomAttribute = /** @class */ (function () {
    function BlackcubeAjaxLinkCustomAttribute(element, templatingEngine, ajaxService) {
        var _this = this;
        this.logger = aurelia_framework_1.LogManager.getLogger('components.BlackcubeAjaxLinkCustomAttribute');
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
    BlackcubeAjaxLinkCustomAttribute.prototype.created = function (owningView, myView) {
        this.logger.debug('Created');
    };
    BlackcubeAjaxLinkCustomAttribute.prototype.bind = function (bindingContext, overrideContext) {
        this.logger.debug('Bind');
    };
    BlackcubeAjaxLinkCustomAttribute.prototype.attached = function () {
        this.logger.debug('Attached');
        this.element.addEventListener('click', this.onDelegateClick);
    };
    BlackcubeAjaxLinkCustomAttribute.prototype.detached = function () {
        this.logger.debug('Detached');
        this.element.removeEventListener('click', this.onDelegateClick);
    };
    BlackcubeAjaxLinkCustomAttribute.prototype.unbind = function () {
        this.logger.debug('Unbind');
    };
    BlackcubeAjaxLinkCustomAttribute = __decorate([
        aurelia_framework_1.inject(aurelia_framework_1.DOM.Element, aurelia_framework_1.TemplatingEngine, AjaxService_1.AjaxService)
    ], BlackcubeAjaxLinkCustomAttribute);
    return BlackcubeAjaxLinkCustomAttribute;
}());
exports.BlackcubeAjaxLinkCustomAttribute = BlackcubeAjaxLinkCustomAttribute;


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
    BlackcubeFileCustomElement.prototype.generatePreviewUrl = function (name) {
        return this.previewUrl.replace('__name__', name);
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
                    _this.storageService.setElementSlugOpened(_this.elementId);
                }
                else {
                    _this.toggleBloc.classList.add('hidden');
                    _this.storageService.setElementSlugClosed(_this.elementId);
                }
            }
        };
        this.onChange = function () {
            if (_this.toggleBloc && _this.toggleCheckbox) {
                if (_this.toggleCheckbox.checked) {
                    _this.toggleBloc.classList.remove('hidden');
                    _this.storageService.setElementSlugOpened(_this.elementId);
                }
                else {
                    _this.toggleBloc.classList.add('hidden');
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
        // PLATFORM.moduleName('components/BlackcubeLoaderCustomAttribute'),
        // PLATFORM.moduleName('components/BlackcubeLoaderDoneCustomAttribute'),
        'components/BlackcubeBlocsCustomAttribute',
        'components/BlackcubeAttachModalCustomAttribute',
        'components/BlackcubeAjaxLinkCustomAttribute',
        'components/BlackcubeFileCustomElement',
        'components/BlackcubeChoicesCustomAttribute',
        'components/BlackcubePieCustomElement'
    ]);
}
exports.configure = configure;


/***/ })

},[[0,"manifest","aurelia","vendor"]]]);
//# sourceMappingURL=app.js.map