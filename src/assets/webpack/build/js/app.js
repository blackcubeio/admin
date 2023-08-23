"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["app"],{

/***/ "./app/components/alert.html":
/*!***********************************!*\
  !*** ./app/components/alert.html ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__),
/* harmony export */   "dependencies": () => (/* binding */ dependencies),
/* harmony export */   "name": () => (/* binding */ name),
/* harmony export */   "register": () => (/* binding */ register),
/* harmony export */   "template": () => (/* binding */ template)
/* harmony export */ });
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");

const name = "alert";
const template = "<template>\n    <div class=\"alert\" aria-labelledby=\"modal-title\" role=\"dialog\" aria-modal=\"true\">\n        <div class=\"alert-wrapper\">\n            <!--\n              Background overlay, show/hide based on modal state.\n\n              Entering: \"ease-out duration-300\"\n                From: \"opacity-0\"\n                To: \"opacity-100\"\n              Leaving: \"ease-in duration-200\"\n                From: \"opacity-100\"\n                To: \"opacity-0\"\n            -->\n            <div ref=\"wrapper\" click.delegate=\"onClickCancel($event)\" class=\"alert-overlay closed\" aria-hidden=\"true\"></div>\n\n            <!-- This element is to trick the browser into centering the modal contents. -->\n            <span class=\"alert-fix\" aria-hidden=\"true\">&#8203;</span>\n\n            <!--\n              Modal panel, show/hide based on modal state.\n\n              Entering: \"ease-out duration-300\"\n                From: \"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95\"\n                To: \"opacity-100 translate-y-0 sm:scale-100\"\n              Leaving: \"ease-in duration-200\"\n                From: \"opacity-100 translate-y-0 sm:scale-100\"\n                To: \"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95\"\n            -->\n            <div ref=\"panel\" class=\"alert-panel closed\">\n                <div class=\"alert-panel-content\">\n                    <div class=\"alert-icon\" class.bind=\"type === alertTypes.CHECK ? 'check' : (type === alertTypes.EXCLAMATION ? 'exclamation': 'question')\">\n                        <!-- Heroicon name: outline/check -->\n                        <svg if.bind=\"type === alertTypes.CHECK\" class=\"alert-icon-img\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" stroke=\"currentColor\">\n                            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\" />\n                        </svg>\n                        <!-- Heroicon name: outline/exclamation -->\n                        <svg if.bind=\"type === alertTypes.EXCLAMATION\" class=\"alert-icon-img\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\" aria-hidden=\"true\">\n                            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z\" />\n                        </svg>\n                        <!-- Heroicon name: outline/information -->\n                        <svg if.bind=\"type === alertTypes.QUESTION\" class=\"alert-icon-img\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\" aria-hidden=\"true\">\n                            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z\" />\n                        </svg>\n                    </div>\n                    <div class=\"mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left\">\n                        <au-compose view.bind=\"htmlData\"></au-compose>\n                    </div>\n                </div>\n                <div class=\"alert-panel-actions\">\n                    <button click.delegate=\"onClickAction($event)\" type=\"button\" class=\"alert-btn\" class.bind=\"type === alertTypes.CHECK ? 'check' : (type === alertTypes.EXCLAMATION ? 'exclamation': 'question')\">\n                        ${actionTitle}\n                    </button>\n                    <button click.delegate=\"onClickCancel($event)\" type=\"button\" class=\"alert-btn\">\n                        ${cancelTitle}\n                    </button>\n                </div>\n            </div>\n        </div>\n    </div>\n</template>\n";
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (template);
const dependencies = [  ];
let _e;
function register(container) {
  if (!_e) {
    _e = _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__.CustomElement.define({ name, template, dependencies });
  }
  container.register(_e);
}


/***/ }),

/***/ "./app/components/blocs.html":
/*!***********************************!*\
  !*** ./app/components/blocs.html ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__),
/* harmony export */   "dependencies": () => (/* binding */ dependencies),
/* harmony export */   "name": () => (/* binding */ name),
/* harmony export */   "register": () => (/* binding */ register),
/* harmony export */   "template": () => (/* binding */ template)
/* harmony export */ });
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");

const name = "blocs";
const template = "<template>\n    <div>\n        <au-compose view.bind=\"view\"></au-compose>\n    </div>\n</template>\n";
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (template);
const dependencies = [  ];
let _e;
function register(container) {
  if (!_e) {
    _e = _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__.CustomElement.define({ name, template, dependencies });
  }
  container.register(_e);
}


/***/ }),

/***/ "./app/components/burger.html":
/*!************************************!*\
  !*** ./app/components/burger.html ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__),
/* harmony export */   "dependencies": () => (/* binding */ dependencies),
/* harmony export */   "name": () => (/* binding */ name),
/* harmony export */   "register": () => (/* binding */ register),
/* harmony export */   "template": () => (/* binding */ template)
/* harmony export */ });
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");

const name = "burger";
const template = "<template>\n    <button ref=\"openMenuBtn\" class=\"px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden\">\n        <span class=\"sr-only\">Open sidebar</span>\n        <!-- Heroicon name: outline/menu-alt-2 -->\n        <svg class=\"h-6 w-6\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\" aria-hidden=\"true\">\n            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M4 6h16M4 12h16M4 18h7\" />\n        </svg>\n    </button>\n</template>\n";
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (template);
const dependencies = [  ];
let _e;
function register(container) {
  if (!_e) {
    _e = _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__.CustomElement.define({ name, template, dependencies });
  }
  container.register(_e);
}


/***/ }),

/***/ "./app/components/composites.html":
/*!****************************************!*\
  !*** ./app/components/composites.html ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__),
/* harmony export */   "dependencies": () => (/* binding */ dependencies),
/* harmony export */   "name": () => (/* binding */ name),
/* harmony export */   "register": () => (/* binding */ register),
/* harmony export */   "template": () => (/* binding */ template)
/* harmony export */ });
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");

const name = "composites";
const template = "<template>\n    <div>\n        <au-compose view.bind=\"view\"></au-compose>\n    </div>\n</template>\n";
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (template);
const dependencies = [  ];
let _e;
function register(container) {
  if (!_e) {
    _e = _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__.CustomElement.define({ name, template, dependencies });
  }
  container.register(_e);
}


/***/ }),

/***/ "./app/components/element-toolbar.html":
/*!*********************************************!*\
  !*** ./app/components/element-toolbar.html ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__),
/* harmony export */   "dependencies": () => (/* binding */ dependencies),
/* harmony export */   "name": () => (/* binding */ name),
/* harmony export */   "register": () => (/* binding */ register),
/* harmony export */   "template": () => (/* binding */ template)
/* harmony export */ });
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");

const name = "element-toolbar";
const template = "<template>\n    <div class=\"page-header-buttons\">\n        <button type=\"button\" class=\"page-header-buttons-button\" class.bind=\"slugActive ? 'active':'inactive'\" click.delegate=\"onClickSlug($event)\">\n            <svg class=\"h-5 w-5\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"2\" stroke=\"currentColor\" aria-hidden=\"true\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1\"></path></svg>\n            <span class=\"ml-2\">${slugTitle}</span>\n        </button>\n        <button if.bind=\"slugExists\" type=\"button\" class=\"page-header-buttons-button\" class.bind=\"sitemapActive ? 'active':'inactive'\" click.delegate=\"onClickSitemap($event)\">\n            <svg class=\"h-5 w-5\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"2\" stroke=\"currentColor\" aria-hidden=\"true\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7\"></path></svg>\n            <span class=\"ml-2\">${sitemapTitle}</span>\n        </button>\n        <span else type=\"button\" class=\"page-header-buttons-button disabled\">\n            <svg class=\"h-5 w-5\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"2\" stroke=\"currentColor\" aria-hidden=\"true\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7\"></path></svg>\n            <span class=\"ml-2\">${sitemapTitle}</span>\n        </span>\n        <button if.bind=\"slugExists\" type=\"button\" class=\"page-header-buttons-button\" class.bind=\"seoActive ? 'active':'inactive'\" click.delegate=\"onClickSeo($event)\">\n            <svg class=\"h-5 w-5\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"2\" stroke=\"currentColor\" aria-hidden=\"true\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M8 16l2.879-2.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242zM21 12a9 9 0 11-18 0 9 9 0 0118 0z\"></path></svg>\n            <span class=\"ml-2\">${seoTitle}</span>\n        </button>\n        <span else type=\"button\" class=\"page-header-buttons-button disabled\">\n            <svg class=\"h-5 w-5\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"2\" stroke=\"currentColor\" aria-hidden=\"true\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M8 16l2.879-2.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242zM21 12a9 9 0 11-18 0 9 9 0 0118 0z\"></path></svg>\n            <span class=\"ml-2\">${seoTitle}</span>\n        </span>\n        <button if.bind=\"showTags\" type=\"button\" class=\"page-header-buttons-button\" click.delegate=\"onClickTags($event)\">\n            <svg class=\"h-5 w-5\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"2\" stroke=\"currentColor\" aria-hidden=\"true\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z\"></path></svg>\n            <span class=\"ml-2\">${tagsTitle}</span>\n        </button>\n    </div>\n</template>\n";
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (template);
const dependencies = [  ];
let _e;
function register(container) {
  if (!_e) {
    _e = _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__.CustomElement.define({ name, template, dependencies });
  }
  container.register(_e);
}


/***/ }),

/***/ "./app/components/file.html":
/*!**********************************!*\
  !*** ./app/components/file.html ***!
  \**********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__),
/* harmony export */   "dependencies": () => (/* binding */ dependencies),
/* harmony export */   "name": () => (/* binding */ name),
/* harmony export */   "register": () => (/* binding */ register),
/* harmony export */   "template": () => (/* binding */ template)
/* harmony export */ });
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");

const name = "file";
const template = "\n    <div class=\"element-form-bloc-upload-wrapper\">\n        <label class=\"element-form-bloc-label\" if.bind=\"title\">\n            ${title}\n        </label>\n        <div class=\"element-form-bloc-upload-input-wrapper\">\n            <div class=\"element-form-bloc-upload-drop\" class.bind=\"error?'error':''\" ref=\"drop\">\n                <div class=\"element-form-bloc-upload-drop-wrapper\">\n                    <svg class=\"element-form-bloc-upload-icon\" ref=\"icon\" stroke=\"currentColor\" fill=\"none\" viewBox=\"0 0 48 48\" aria-hidden=\"true\">\n                        <path d=\"M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"></path>\n                    </svg>\n                    <div class=\"element-form-bloc-upload-drop-input-wrapper\" ref=\"browse\">\n                        <label class=\"element-form-bloc-upload-drop-input-label\">\n                            <span>${uploadFileText}</span>\n                        </label>\n                        <p class=\"element-form-bloc-upload-drop-input-accessory\">${uploadFileDnd}</p>\n                    </div>\n                    <p class=\"element-form-bloc-abstract\">\n                        ${fileInfo}\n                    </p>\n                </div>\n            </div>\n        </div>\n        <p class=\"element-form-bloc-abstract\">${uploadFileDescription}</p>\n        <ul class=\"w-full\">\n            <li class=\"inline-block text-gray-600 text-center p-2 relative\" repeat.for=\"handledFile of handledFiles\">\n                <button click.trigger=\"onRemove(handledFile, $event)\" class=\"absolute top-0 right-0 rounded-full p-1 text-center bg-white border-gray-600 border h-6 w-6 flex items-center justify-center text-xs hover:border-red-700 hover:text-red-700\">\n                    <svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-4 w-4\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\" stroke-width=\"2\">\n                        <path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16\" />\n                    </svg>\n                </button>\n                <img class=\"object-contain h-24\" src.bind=\"handledFile.previewUrl\" title.bind=\"handledFile.shortname\">\n            </li>\n        </ul>\n    </div>\n";
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (template);
const dependencies = [  ];
let _e;
function register(container) {
  if (!_e) {
    _e = _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__.CustomElement.define({ name, template, dependencies });
  }
  container.register(_e);
}


/***/ }),

/***/ "./app/components/notification-center.html":
/*!*************************************************!*\
  !*** ./app/components/notification-center.html ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__),
/* harmony export */   "dependencies": () => (/* binding */ dependencies),
/* harmony export */   "name": () => (/* binding */ name),
/* harmony export */   "register": () => (/* binding */ register),
/* harmony export */   "template": () => (/* binding */ template)
/* harmony export */ });
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");

const name = "notification-center";
const template = "<template>\n    <div aria-live=\"assertive\" class=\"notification-center\">\n        <blackcube-notification repeat.for=\"notification of notifications\"\n                                class=\"notification\"\n            type.bind=\"notification.type\"\n        title.bind=\"notification.title\"\n        content.bind=\"notification.content\"\n        index.bind=\"$index\"\n        duration.bind=\"notification.duration\">\n        </blackcube-notification>\n    </div>\n</template>\n";
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (template);
const dependencies = [  ];
let _e;
function register(container) {
  if (!_e) {
    _e = _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__.CustomElement.define({ name, template, dependencies });
  }
  container.register(_e);
}


/***/ }),

/***/ "./app/components/notification.html":
/*!******************************************!*\
  !*** ./app/components/notification.html ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__),
/* harmony export */   "dependencies": () => (/* binding */ dependencies),
/* harmony export */   "name": () => (/* binding */ name),
/* harmony export */   "register": () => (/* binding */ register),
/* harmony export */   "template": () => (/* binding */ template)
/* harmony export */ });
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");

const name = "notification";
const template = "<template>\n        <!--\n          NotificationData panel, dynamically insert this into the live region when it needs to be displayed\n\n          Entering: \"transform ease-out duration-300 transition\"\n            From: \"translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2\"\n            To: \"translate-y-0 opacity-100 sm:translate-x-0\"\n          Leaving: \"transition ease-in duration-100\"\n            From: \"opacity-100\"\n            To: \"opacity-0\"\n        -->\n        <div ref=\"wrapper\" class=\"notification-wrapper closed\">\n            <div class=\"notification-icon\">\n                <!-- Heroicon name: outline/check-circle -->\n                <svg if.bind=\"type === notificationTypes.CHECK\" class=\"notification-icon-img check\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\" aria-hidden=\"true\">\n                    <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z\" />\n                </svg>\n                <!-- Heroicon name: outline/exclamation -->\n                <svg if.bind=\"type === notificationTypes.EXCLAMATION\" class=\"notification-icon-img exclamation\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\" aria-hidden=\"true\">\n                    <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z\" />\n                </svg>\n                <!-- Heroicon name: outline/information -->\n                <svg if.bind=\"type === notificationTypes.INFORMATION\" class=\"notification-icon-img\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\" aria-hidden=\"true\">\n                    <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z\" />\n                </svg>\n            </div>\n            <div class=\"notification-panel\">\n                <p class=\"notification-title\">\n                    ${title}\n                </p>\n                <p class=\"notification-content\">\n                    ${content}\n                </p>\n            </div>\n            <div class=\"notification-btn-wrapper\">\n                <button  click.delegate=\"onClose($event)\" class=\"notification-btn\">\n                    <span class=\"sr-only\">Close</span>\n                    <!-- Heroicon name: solid/x -->\n                    <svg class=\"notification-close\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 20 20\" fill=\"currentColor\" aria-hidden=\"true\">\n                        <path fill-rule=\"evenodd\" d=\"M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z\" clip-rule=\"evenodd\" />\n                    </svg>\n                </button>\n            </div>\n        </div>\n</template>\n";
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (template);
const dependencies = [  ];
let _e;
function register(container) {
  if (!_e) {
    _e = _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__.CustomElement.define({ name, template, dependencies });
  }
  container.register(_e);
}


/***/ }),

/***/ "./app/components/overlay.html":
/*!*************************************!*\
  !*** ./app/components/overlay.html ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__),
/* harmony export */   "dependencies": () => (/* binding */ dependencies),
/* harmony export */   "name": () => (/* binding */ name),
/* harmony export */   "register": () => (/* binding */ register),
/* harmony export */   "template": () => (/* binding */ template)
/* harmony export */ });
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");

const name = "overlay";
const template = "<template>\n    <div class=\"overlay-wrapper\">\n        <!--\n          Background overlay, show/hide based on slide-over state.\n\n          Entering: \"ease-in-out duration-500\"\n            From: \"opacity-0\"\n            To: \"opacity-100\"\n          Leaving: \"ease-in-out duration-500\"\n            From: \"opacity-100\"\n            To: \"opacity-0\"\n        -->\n        <div ref=\"overlay\" click.delegate=\"onClickClose($event)\" class=\"overlay-overlay closed\" aria-hidden=\"true\"></div>\n\n        <div class=\"overlay-content\">\n            <!--\n              Slide-over panel, show/hide based on slide-over state.\n\n              Entering: \"transform transition ease-in-out duration-500 sm:duration-700\"\n                From: \"translate-x-full\"\n                To: \"translate-x-0\"\n              Leaving: \"transform transition ease-in-out duration-500 sm:duration-700\"\n                From: \"translate-x-0\"\n                To: \"translate-x-full\"\n            -->\n            <div ref=\"panel\" class=\"overlay-panel closed\">\n                <div class=\"overlay-panel-wrapper\"><!-- innerHTML.bind=\"htmlData\" -->\n                    <!-- Replace with your content -->\n                    <au-compose view.bind=\"htmlData\"></au-compose>\n\n                    <!-- /End replace -->\n                </div>\n            </div>\n        </div>\n    </div>\n</template>\n";
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (template);
const dependencies = [  ];
let _e;
function register(container) {
  if (!_e) {
    _e = _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__.CustomElement.define({ name, template, dependencies });
  }
  container.register(_e);
}


/***/ }),

/***/ "./app/components/permissions.html":
/*!*****************************************!*\
  !*** ./app/components/permissions.html ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__),
/* harmony export */   "dependencies": () => (/* binding */ dependencies),
/* harmony export */   "name": () => (/* binding */ name),
/* harmony export */   "register": () => (/* binding */ register),
/* harmony export */   "template": () => (/* binding */ template)
/* harmony export */ });
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");

const name = "permissions";
const template = "<template>\n    <div>\n        <au-compose view.bind=\"view\"></au-compose>\n    </div>\n</template>\n";
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (template);
const dependencies = [  ];
let _e;
function register(container) {
  if (!_e) {
    _e = _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__.CustomElement.define({ name, template, dependencies });
  }
  container.register(_e);
}


/***/ }),

/***/ "./app/components/profile.html":
/*!*************************************!*\
  !*** ./app/components/profile.html ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__),
/* harmony export */   "dependencies": () => (/* binding */ dependencies),
/* harmony export */   "name": () => (/* binding */ name),
/* harmony export */   "register": () => (/* binding */ register),
/* harmony export */   "template": () => (/* binding */ template)
/* harmony export */ });
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");

const name = "profile";
const template = "<template>\n    <div>\n        <button type=\"button\" class=\"profile-btn\" click.delegate=\"onToggle($event)\" id=\"user-menu-button\" aria-expanded=\"false\" aria-haspopup=\"true\">\n            <span class=\"sr-only\">Open user menu</span>\n            <img if.bind=\"avatar\" class=\"profile-img\" src.bind=\"avatar\" alt=\"\">\n            <span else class=\"profile-initials\">\n                <span class=\"profile-initials-letters\">${initials}</span>\n            </span>\n        </button>\n    </div>\n    <div if.bind=\"items.length > 0\" ref=\"menu\" class=\"profile-menu closed\"  role=\"menu\" aria-orientation=\"vertical\" aria-labelledby=\"user-menu-button\" tabindex=\"-1\">\n        <a repeat.for=\"item of items\" click.delegate=\"onClickItem($event, $index)\" href.bind=\"item.url\" class=\"profile-menu-item\" class.bind=\"item.active ? 'active': ''\" role=\"menuitem\" tabindex=\"-1\" innerHTML.bind=\"item.label\"></a>\n    </div>\n</template>\n";
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (template);
const dependencies = [  ];
let _e;
function register(container) {
  if (!_e) {
    _e = _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__.CustomElement.define({ name, template, dependencies });
  }
  container.register(_e);
}


/***/ }),

/***/ "./app/components/quill-editor.html":
/*!******************************************!*\
  !*** ./app/components/quill-editor.html ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__),
/* harmony export */   "dependencies": () => (/* binding */ dependencies),
/* harmony export */   "name": () => (/* binding */ name),
/* harmony export */   "register": () => (/* binding */ register),
/* harmony export */   "template": () => (/* binding */ template)
/* harmony export */ });
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");

const name = "quill-editor";
const template = "<template>\n    <input type=\"hidden\" ref=\"hiddenField\">\n    <div ref=\"editorElement\"></div>\n\n</template>\n";
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (template);
const dependencies = [  ];
let _e;
function register(container) {
  if (!_e) {
    _e = _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__.CustomElement.define({ name, template, dependencies });
  }
  container.register(_e);
}


/***/ }),

/***/ "./app/components/schema-editor.html":
/*!*******************************************!*\
  !*** ./app/components/schema-editor.html ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__),
/* harmony export */   "dependencies": () => (/* binding */ dependencies),
/* harmony export */   "name": () => (/* binding */ name),
/* harmony export */   "register": () => (/* binding */ register),
/* harmony export */   "template": () => (/* binding */ template)
/* harmony export */ });
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");

const name = "schema-editor";
const template = "<template>\n    <input type=\"hidden\" ref=\"hiddenField\"/>\n    <div ref=\"editorElement\"></div>\n</template>\n";
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (template);
const dependencies = [  ];
let _e;
function register(container) {
  if (!_e) {
    _e = _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__.CustomElement.define({ name, template, dependencies });
  }
  container.register(_e);
}


/***/ }),

/***/ "./app/components/test.html":
/*!**********************************!*\
  !*** ./app/components/test.html ***!
  \**********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__),
/* harmony export */   "dependencies": () => (/* binding */ dependencies),
/* harmony export */   "name": () => (/* binding */ name),
/* harmony export */   "register": () => (/* binding */ register),
/* harmony export */   "template": () => (/* binding */ template)
/* harmony export */ });
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");

const name = "test";
const template = "<template>\n\n    Test component with button\n\n    <button click.delegate=\"onClick($event)\">Click me</button>\n</template>";
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (template);
const dependencies = [  ];
let _e;
function register(container) {
  if (!_e) {
    _e = _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_0__.CustomElement.define({ name, template, dependencies });
  }
  container.register(_e);
}


/***/ }),

/***/ "./app/attributes/ajaxify.ts":
/*!***********************************!*\
  !*** ./app/attributes/ajaxify.ts ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Ajaxify": () => (/* binding */ Ajaxify)
/* harmony export */ });
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! aurelia */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");
/* harmony import */ var _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/kernel */ "../../../../node_modules/@aurelia/kernel/dist/esm/index.js");
/* harmony import */ var _services_http_service__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../services/http-service */ "./app/services/http-service.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (undefined && undefined.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};




let Ajaxify = class Ajaxify {
    constructor(logger, platform, httpService, element) {
        this.logger = logger;
        this.platform = platform;
        this.httpService = httpService;
        this.element = element;
        this.onDelegateEvent = (evt) => {
            if (evt.target) {
                const el = evt.target;
                const triggerElement = el.closest('[data-ajaxify-source]');
                if (triggerElement) {
                    const source = triggerElement.dataset.ajaxifySource;
                    let url = triggerElement.dataset.ajaxifyUrl;
                    if (!url && (triggerElement instanceof HTMLLinkElement || triggerElement instanceof HTMLAnchorElement)) {
                        url = triggerElement.href;
                    }
                    const targetElement = this.element.querySelector('[data-ajaxify-target="' + source + '"]');
                    if (source && url && targetElement) {
                        evt.preventDefault();
                        this.httpService.getHtmlContent(url)
                            .then((htmlData) => {
                            targetElement.innerHTML = htmlData;
                            this.platform.taskQueue.queueTask(() => {
                                targetElement.scrollIntoView({ behavior: "smooth" });
                            });
                        });
                    }
                }
            }
        };
        this.logger = logger.scopeTo('Ajaxify');
    }
    attaching() {
        this.logger.trace('Attaching');
    }
    attached() {
        this.element.addEventListener('click', this.onDelegateEvent);
        this.logger.trace('Attached');
    }
    detaching() {
        this.logger.trace('Detaching');
        this.element.removeEventListener('click', this.onDelegateEvent);
    }
};
Ajaxify = __decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_2__.customAttribute)('blackcube-ajaxify'),
    __param(0, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__.ILogger),
    __param(1, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_2__.IPlatform),
    __param(3, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_2__.INode),
    __metadata("design:paramtypes", [Object, Object, _services_http_service__WEBPACK_IMPORTED_MODULE_1__.HttpService,
        HTMLElement])
], Ajaxify);



/***/ }),

/***/ "./app/attributes/alert-delete.ts":
/*!****************************************!*\
  !*** ./app/attributes/alert-delete.ts ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "AlertDelete": () => (/* binding */ AlertDelete)
/* harmony export */ });
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");
/* harmony import */ var _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/kernel */ "../../../../node_modules/@aurelia/kernel/dist/esm/index.js");
/* harmony import */ var _components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components */ "./app/components/index.ts");
/* harmony import */ var _interfaces_alert__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../interfaces/alert */ "./app/interfaces/alert.ts");
/* harmony import */ var _services_http_service__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../services/http-service */ "./app/services/http-service.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (undefined && undefined.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};





let AlertDelete = class AlertDelete {
    constructor(logger, ea, httpService, element) {
        this.logger = logger;
        this.ea = ea;
        this.httpService = httpService;
        this.element = element;
        this.action = 'Delete';
        this.cancel = 'Cancel';
        this.onDelegateEvent = (event) => {
            if (event.target) {
                const el = event.target;
                const triggerElement = el.closest('[data-alert-delete]');
                if (triggerElement instanceof HTMLAnchorElement) {
                    const contentUrl = triggerElement.dataset.alertDelete;
                    const method = triggerElement.dataset.alertDeleteMethod || 'post';
                    const targetUrl = triggerElement.href;
                    if (contentUrl && contentUrl.length > 1) {
                        event.preventDefault();
                        this.ea.publish(_components__WEBPACK_IMPORTED_MODULE_1__.Alert.channel, {
                            type: _interfaces_alert__WEBPACK_IMPORTED_MODULE_2__.AlertEventType.OPEN,
                            alert: {
                                type: _interfaces_alert__WEBPACK_IMPORTED_MODULE_2__.AlertType.EXCLAMATION,
                                contentUrl,
                                actionTitle: this.action,
                                cancelTitle: this.cancel,
                                cancel: () => { this.logger.trace('Should Close'); },
                                action: () => {
                                    var _a;
                                    const csrfField = (_a = triggerElement.closest('form')) === null || _a === void 0 ? void 0 : _a.querySelector('input[name=_csrf]');
                                    const body = new FormData();
                                    if (csrfField) {
                                        body.append(csrfField.name, csrfField.value);
                                    }
                                    this.httpService.fetch(targetUrl, { method, body })
                                        .then((data) => {
                                        const url = data.headers.get('X-Redirect');
                                        if (url) {
                                            window.location.href = url;
                                        }
                                        this.logger.trace('daya', data.headers);
                                    });
                                    // window.location.href = targetUrl;
                                }
                            }
                        });
                    }
                }
            }
        };
        this.logger = logger.scopeTo('ModalAlert');
    }
    attaching() {
        this.logger.trace('Attaching');
    }
    attached() {
        this.logger.trace('Attached');
        this.element.addEventListener('click', this.onDelegateEvent);
    }
    detaching() {
        this.logger.trace('Detaching');
        this.element.removeEventListener('click', this.onDelegateEvent);
    }
};
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.bindable)(),
    __metadata("design:type", String)
], AlertDelete.prototype, "action", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.bindable)(),
    __metadata("design:type", String)
], AlertDelete.prototype, "cancel", void 0);
AlertDelete = __decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.customAttribute)('blackcube-alert-delete'),
    __param(0, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__.ILogger),
    __param(1, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__.IEventAggregator),
    __param(3, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.INode),
    __metadata("design:paramtypes", [Object, Object, _services_http_service__WEBPACK_IMPORTED_MODULE_3__.HttpService,
        HTMLElement])
], AlertDelete);



/***/ }),

/***/ "./app/attributes/bc-test-custom-attribute.ts":
/*!****************************************************!*\
  !*** ./app/attributes/bc-test-custom-attribute.ts ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "BcTestCustomAttribute": () => (/* binding */ BcTestCustomAttribute)
/* harmony export */ });
/* harmony import */ var _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/kernel */ "../../../../node_modules/@aurelia/kernel/dist/esm/index.js");
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (undefined && undefined.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};


let BcTestCustomAttribute = class BcTestCustomAttribute {
    constructor(logger, ea, element) {
        this.logger = logger;
        this.ea = ea;
        this.element = element;
        this.logger = logger.scopeTo('BcTestCustomAttribute');
    }
    attaching() {
        this.logger.trace('Attaching');
        /*/
        this.openMenuBtn = this.element.querySelector('[x-ref=opensidebar]') as HTMLButtonElement;
        this.openMenuBtn.addEventListener('click', (evt: Event) => {
            evt.preventDefault();
            this.ea.publish(Menu.channel, {type: MenuEventType.OPEN});
        });
        /**/
        /*/
        setTimeout(() => {
            this.ea.publish(Overlay.channel, {
                type: OverlayEventType.OPEN,
                overlay: {
                    title: 'Titre Overlay 1',
                    abstract: 'Contenu Alerte',
                    url: '/form.html'
                }
            });

        }, 5000);
        setTimeout(() => {
            this.ea.publish(Overlay.channel, {
                type: OverlayEventType.OPEN,
                overlay: {
                    title: 'Titre Overlay 2',
                    abstract: 'Contenu Alerte',
                    url: '/form.html',
                    actionTitle: 'Save',
                    cancel: () => { this.logger.warn('Clicked cancel')}
                }
            });

        }, 8000);
        /**/
        /*/
        setTimeout(() => {
            this.ea.publish(Alert.channel, {
                type: AlertEventType.OPEN,
                alert: {
                    type: AlertType.QUESTION,
                    title: 'Titre Alerte',
                    content: 'Contenu Alerte',
                    action: () => {
                        this.logger.warn('Closing with action')
                    },
                    cancel: () => {
                        this.logger.warn('Closing with cancel')
                    }
                }
            });
        }, 2500);
        /**/
        /*/
        setTimeout(() => {
            this.ea.publish(Alert.channel, {
                type: AlertEventType.CLOSE,
                alert: {
                    type: AlertType.EXCLAMATION,
                    title: 'Titre Alerte',
                    content: 'Contenu Alerte'
                }
            });
        }, 12500);
        /**/
        /*/
        setTimeout(() => {
            this.ea.publish(NotificationCenter.channel, {
                type: NotificationCenterEventType.CREATE,
                notification: {
                    title: 'Test stuff',
                    type: NotificationType.EXCLAMATION,
                    content: 'Et le contenu de la notification',
                    duration: 5000                }
            });
        }, 1500);
        setTimeout(() => {
            this.ea.publish(NotificationCenter.channel, {
                type: NotificationCenterEventType.CREATE,
                notification: {
                    title: 'Test stuff',
                    type: NotificationType.EXCLAMATION,
                    content: 'Et le contenu de la notification',
                    duration: 5000                }
            });
        }, 2000);
        setTimeout(() => {
            this.ea.publish(NotificationCenter.channel, {
                type: NotificationCenterEventType.CREATE,
                notification: {
                    title: 'Test stuff',
                    type: NotificationType.EXCLAMATION,
                    content: 'Et le contenu de la notification',
                    duration: 5000                }
            });
        }, 2500);
        setTimeout(() => {
            this.ea.publish(NotificationCenter.channel, {
                type: NotificationCenterEventType.CREATE,
                notification: {
                    title: 'Test stuff',
                    type: NotificationType.EXCLAMATION,
                    content: 'Et le contenu de la notification',
                    duration: 5000                }
            });
        }, 3000);
        /**/
        /*/
        setTimeout(() => {
            this.ea.publish(NotificationCenter.channel, {
                type: NotificationCenterEventType.REMOVE_ALL
            });
        }, 5500);
        /**/
    }
};
BcTestCustomAttribute = __decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_1__.customAttribute)('bc-test'),
    __param(0, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__.ILogger),
    __param(1, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__.IEventAggregator),
    __param(2, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_1__.INode),
    __metadata("design:paramtypes", [Object, Object, HTMLElement])
], BcTestCustomAttribute);



/***/ }),

/***/ "./app/attributes/broadcast-element.ts":
/*!*********************************************!*\
  !*** ./app/attributes/broadcast-element.ts ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "BroadcastElement": () => (/* binding */ BroadcastElement)
/* harmony export */ });
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");
/* harmony import */ var _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/kernel */ "../../../../node_modules/@aurelia/kernel/dist/esm/index.js");
/* harmony import */ var _interfaces_broadcast__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../interfaces/broadcast */ "./app/interfaces/broadcast.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (undefined && undefined.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};



let BroadcastElement = class BroadcastElement {
    constructor(logger, ea, element) {
        this.logger = logger;
        this.ea = ea;
        this.element = element;
        this.logger = logger.scopeTo('BroadcastElement');
    }
    attached() {
        this.logger.trace('Attaching');
        if (this.event) {
            this.ea.publish(_interfaces_broadcast__WEBPACK_IMPORTED_MODULE_1__.Broadcast.channel, {
                type: this.event,
                data: {
                    type: this.type,
                    id: this.id
                }
            });
        }
        else if (this.events) {
            this.events.forEach((event) => {
                this.ea.publish(_interfaces_broadcast__WEBPACK_IMPORTED_MODULE_1__.Broadcast.channel, {
                    type: event,
                    data: {
                        type: this.type,
                        id: this.id
                    }
                });
            });
        }
    }
};
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_2__.bindable)(),
    __metadata("design:type", String)
], BroadcastElement.prototype, "event", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_2__.bindable)(),
    __metadata("design:type", Array)
], BroadcastElement.prototype, "events", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_2__.bindable)(),
    __metadata("design:type", String)
], BroadcastElement.prototype, "type", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_2__.bindable)(),
    __metadata("design:type", Object)
], BroadcastElement.prototype, "id", void 0);
BroadcastElement = __decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_2__.customAttribute)('blackcube-broadcast-element'),
    __param(0, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__.ILogger),
    __param(1, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__.IEventAggregator),
    __param(2, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_2__.INode),
    __metadata("design:paramtypes", [Object, Object, HTMLElement])
], BroadcastElement);



/***/ }),

/***/ "./app/attributes/fold.ts":
/*!********************************!*\
  !*** ./app/attributes/fold.ts ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Fold": () => (/* binding */ Fold)
/* harmony export */ });
/* harmony import */ var aurelia__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! aurelia */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");
/* harmony import */ var _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/kernel */ "../../../../node_modules/@aurelia/kernel/dist/esm/index.js");
/* harmony import */ var _services_http_service__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../services/http-service */ "./app/services/http-service.ts");
/* harmony import */ var _services_StorageService__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../services/StorageService */ "./app/services/StorageService.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (undefined && undefined.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};





let Fold = class Fold {
    constructor(logger, platform, httpService, storageService, element) {
        this.logger = logger;
        this.platform = platform;
        this.httpService = httpService;
        this.storageService = storageService;
        this.element = element;
        this.onDelegateEvent = (evt) => {
            if (evt.target) {
                const el = evt.target;
                const triggerElement = el.closest('[data-fold]');
                if (triggerElement) {
                    const mode = triggerElement.dataset.fold;
                    evt.preventDefault();
                    evt.stopPropagation();
                    this.toggle();
                }
            }
        };
        this.logger = logger.scopeTo('Fold');
    }
    attaching() {
        this.logger.trace('Attaching');
    }
    attached() {
        var _a, _b, _c, _d, _e, _f;
        this.targetElement = this.element.querySelector('[data-target-fold]');
        this.openElement = this.element.querySelector('[data-fold=down]');
        this.closeElement = this.element.querySelector('[data-fold=up]');
        this.element.addEventListener('click', this.onDelegateEvent);
        this.logger.trace('Attached');
        const isOpened = this.storageService.getElementOpened(this.elementType, this.elementSubData, this.elementId);
        if (isOpened) {
            (_a = this.openElement) === null || _a === void 0 ? void 0 : _a.classList.remove('hidden');
            (_b = this.closeElement) === null || _b === void 0 ? void 0 : _b.classList.add('hidden');
            (_c = this.targetElement) === null || _c === void 0 ? void 0 : _c.classList.remove('hidden');
        }
        else {
            (_d = this.openElement) === null || _d === void 0 ? void 0 : _d.classList.add('hidden');
            (_e = this.closeElement) === null || _e === void 0 ? void 0 : _e.classList.remove('hidden');
            (_f = this.targetElement) === null || _f === void 0 ? void 0 : _f.classList.add('hidden');
        }
    }
    detaching() {
        this.logger.trace('Detaching');
        this.element.removeEventListener('click', this.onDelegateEvent);
    }
    toggle() {
        var _a, _b, _c, _d, _e, _f, _g;
        if ((_a = this.targetElement) === null || _a === void 0 ? void 0 : _a.classList.contains('hidden')) {
            (_b = this.openElement) === null || _b === void 0 ? void 0 : _b.classList.remove('hidden');
            (_c = this.closeElement) === null || _c === void 0 ? void 0 : _c.classList.add('hidden');
            (_d = this.targetElement) === null || _d === void 0 ? void 0 : _d.classList.remove('hidden');
            this.storageService.setElementOpened(this.elementType, this.elementSubData, this.elementId);
        }
        else {
            (_e = this.openElement) === null || _e === void 0 ? void 0 : _e.classList.add('hidden');
            (_f = this.closeElement) === null || _f === void 0 ? void 0 : _f.classList.remove('hidden');
            (_g = this.targetElement) === null || _g === void 0 ? void 0 : _g.classList.add('hidden');
            this.storageService.setElementClosed(this.elementType, this.elementSubData, this.elementId);
        }
    }
};
__decorate([
    (0,aurelia__WEBPACK_IMPORTED_MODULE_3__.bindable)(),
    __metadata("design:type", String)
], Fold.prototype, "elementId", void 0);
__decorate([
    (0,aurelia__WEBPACK_IMPORTED_MODULE_3__.bindable)(),
    __metadata("design:type", String)
], Fold.prototype, "elementType", void 0);
__decorate([
    (0,aurelia__WEBPACK_IMPORTED_MODULE_3__.bindable)(),
    __metadata("design:type", String)
], Fold.prototype, "elementSubData", void 0);
Fold = __decorate([
    (0,aurelia__WEBPACK_IMPORTED_MODULE_3__.customAttribute)('blackcube-fold'),
    __param(0, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__.ILogger),
    __param(1, aurelia__WEBPACK_IMPORTED_MODULE_3__.IPlatform),
    __param(4, aurelia__WEBPACK_IMPORTED_MODULE_3__.INode),
    __metadata("design:paramtypes", [Object, Object, _services_http_service__WEBPACK_IMPORTED_MODULE_1__.HttpService,
        _services_StorageService__WEBPACK_IMPORTED_MODULE_2__.StorageService,
        HTMLElement])
], Fold);



/***/ }),

/***/ "./app/attributes/index.ts":
/*!*********************************!*\
  !*** ./app/attributes/index.ts ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Ajaxify": () => (/* reexport safe */ _ajaxify__WEBPACK_IMPORTED_MODULE_2__.Ajaxify),
/* harmony export */   "AlertDelete": () => (/* reexport safe */ _alert_delete__WEBPACK_IMPORTED_MODULE_3__.AlertDelete),
/* harmony export */   "BcTestCustomAttribute": () => (/* reexport safe */ _bc_test_custom_attribute__WEBPACK_IMPORTED_MODULE_0__.BcTestCustomAttribute),
/* harmony export */   "BroadcastElement": () => (/* reexport safe */ _broadcast_element__WEBPACK_IMPORTED_MODULE_7__.BroadcastElement),
/* harmony export */   "Fold": () => (/* reexport safe */ _fold__WEBPACK_IMPORTED_MODULE_9__.Fold),
/* harmony export */   "Menu": () => (/* reexport safe */ _menu__WEBPACK_IMPORTED_MODULE_1__.Menu),
/* harmony export */   "NotificationTrigger": () => (/* reexport safe */ _notification_trigger__WEBPACK_IMPORTED_MODULE_5__.NotificationTrigger),
/* harmony export */   "OverlayClose": () => (/* reexport safe */ _overlay_close__WEBPACK_IMPORTED_MODULE_6__.OverlayClose),
/* harmony export */   "OverlayTrigger": () => (/* reexport safe */ _overlay_trigger__WEBPACK_IMPORTED_MODULE_4__.OverlayTrigger),
/* harmony export */   "ToggleDependencies": () => (/* reexport safe */ _toggle_dependencies__WEBPACK_IMPORTED_MODULE_8__.ToggleDependencies)
/* harmony export */ });
/* harmony import */ var _bc_test_custom_attribute__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./bc-test-custom-attribute */ "./app/attributes/bc-test-custom-attribute.ts");
/* harmony import */ var _menu__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./menu */ "./app/attributes/menu.ts");
/* harmony import */ var _ajaxify__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ajaxify */ "./app/attributes/ajaxify.ts");
/* harmony import */ var _alert_delete__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./alert-delete */ "./app/attributes/alert-delete.ts");
/* harmony import */ var _overlay_trigger__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./overlay-trigger */ "./app/attributes/overlay-trigger.ts");
/* harmony import */ var _notification_trigger__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./notification-trigger */ "./app/attributes/notification-trigger.ts");
/* harmony import */ var _overlay_close__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./overlay-close */ "./app/attributes/overlay-close.ts");
/* harmony import */ var _broadcast_element__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./broadcast-element */ "./app/attributes/broadcast-element.ts");
/* harmony import */ var _toggle_dependencies__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./toggle-dependencies */ "./app/attributes/toggle-dependencies.ts");
/* harmony import */ var _fold__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./fold */ "./app/attributes/fold.ts");












/***/ }),

/***/ "./app/attributes/menu.ts":
/*!********************************!*\
  !*** ./app/attributes/menu.ts ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Menu": () => (/* binding */ Menu)
/* harmony export */ });
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! aurelia */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");
/* harmony import */ var _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/kernel */ "../../../../node_modules/@aurelia/kernel/dist/esm/index.js");
/* harmony import */ var _interfaces_menu__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../interfaces/menu */ "./app/interfaces/menu.ts");
/* harmony import */ var _services_StorageService__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../services/StorageService */ "./app/services/StorageService.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (undefined && undefined.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};
var Menu_1;





let Menu = Menu_1 = class Menu {
    constructor(logger, ea, platform, storageService, element) {
        this.logger = logger;
        this.ea = ea;
        this.platform = platform;
        this.storageService = storageService;
        this.element = element;
        this.onClickExpander = (evt) => {
            const clickedNode = evt.currentTarget;
            const parentNode = clickedNode.closest('.navbar-item');
            const currentSectionData = parentNode.dataset.blackcubeSection;
            if (parentNode.classList.contains('expanded')) {
                parentNode.classList.remove('expanded');
                if (currentSectionData) {
                    this.storageService.setSectionClosed('menu', currentSectionData);
                }
            }
            else {
                parentNode.classList.add('expanded');
                if (currentSectionData) {
                    this.storageService.setSectionOpened('menu', currentSectionData);
                }
            }
        };
        this.onMenuEvent = (event) => {
            if (this.isMobile) {
                if (event.type === _interfaces_menu__WEBPACK_IMPORTED_MODULE_1__.MenuEventType.OPEN) {
                    // this.logger.debug('Should open menu');
                    this.openWithTransition();
                }
                else if (event.type === _interfaces_menu__WEBPACK_IMPORTED_MODULE_1__.MenuEventType.CLOSE) {
                    // this.logger.debug('Should close menu');
                    this.closeWithTransition();
                }
            }
        };
        this.onCloseMobileMenu = (evt) => {
            evt.preventDefault();
            this.ea.publish(Menu_1.channel, { type: _interfaces_menu__WEBPACK_IMPORTED_MODULE_1__.MenuEventType.CLOSE });
            this.logger.trace('Close mobile menu');
        };
        this.logger = logger.scopeTo('Menu');
    }
    attaching() {
        this.logger.trace('Attaching');
        // this.menuMobile = this.element.querySelector('.menu-mobile') as HTMLDivElement;
        if (this.element.classList.contains('menu-mobile')) {
            this.isMobile = true;
            this.element.style.display = 'none';
            this.menuMobileCloseBtn = this.element.querySelector('[data-ref=close]');
            this.menuMobileClosePanel = this.element.querySelector('[data-ref=closepanel]');
            this.menuMobileOffcanvas = this.element.querySelector('[data-ref=offcanvas]');
            this.menuMobileOverlay = this.element.querySelector('[data-ref=overlay]');
            this.menuMobileSubscriber = this.ea.subscribe(Menu_1.channel, this.onMenuEvent);
        }
        else if (this.element.classList.contains('menu-desktop')) {
            this.isMobile = false;
            this.menuDesktop = this.element.querySelector('.menu-desktop');
        }
        this.expanders = this.element.querySelectorAll('.navbar-item-btn');
    }
    attached() {
        this.logger.trace('Attached');
        if (this.isMobile && this.menuMobileCloseBtn) {
            this.menuMobileCloseBtn.addEventListener('click', this.onCloseMobileMenu);
        }
        const currentSections = this.element.querySelectorAll('[data-blackcube-section]');
        currentSections.forEach((section) => {
            const currentSectionData = section.dataset.blackcubeSection;
            if (currentSectionData) {
                let opened = this.storageService.getSectionOpened('menu', currentSectionData);
                if (opened) {
                    section.classList.add('expanded');
                }
                else {
                    section.classList.remove('expanded');
                }
            }
        });
        this.expanders.forEach((expander, index) => {
            expander.addEventListener('click', this.onClickExpander);
        });
    }
    detaching() {
        this.logger.trace('Detached');
        this.expanders.forEach((expander, index) => {
            expander.removeEventListener('click', this.onClickExpander);
        });
        if (this.isMobile) {
            this.menuMobileCloseBtn.removeEventListener('click', this.onCloseMobileMenu);
        }
    }
    openWithTransition() {
        this.element.style.display = 'inherit';
        this.ea.publish(Menu_1.channel, {
            status: _interfaces_menu__WEBPACK_IMPORTED_MODULE_1__.MenuStatus.OPENING
        });
        const animationPromise = new Promise((resolve) => {
            setTimeout(() => {
                resolve(true);
            });
        });
        return animationPromise
            .then((status) => {
            const animationPromises = [];
            const overlayPromise = new Promise((resolve) => {
                const endWrapperTransition = (evt) => {
                    if (this.menuMobileOverlay.classList.contains('opening')) {
                        this.menuMobileOverlay.classList.remove('opening', 'closed');
                        this.menuMobileOverlay.removeEventListener('transitionend', endWrapperTransition);
                        resolve(true);
                    }
                };
                this.menuMobileOverlay.addEventListener('transitionend', endWrapperTransition);
                this.menuMobileOverlay.classList.remove('closed');
                this.menuMobileOverlay.classList.add('opening', 'opened');
            });
            animationPromises.push(overlayPromise);
            const offcanvasPromise = new Promise((resolve) => {
                const endWrapperTransition = (evt) => {
                    if (this.menuMobileOffcanvas.classList.contains('opening')) {
                        this.menuMobileOffcanvas.classList.remove('opening', 'closed');
                        this.menuMobileOffcanvas.removeEventListener('transitionend', endWrapperTransition);
                        resolve(true);
                    }
                };
                this.menuMobileOffcanvas.addEventListener('transitionend', endWrapperTransition);
                this.menuMobileOffcanvas.classList.remove('closed');
                this.menuMobileOffcanvas.classList.add('opening', 'opened');
            });
            animationPromises.push(offcanvasPromise);
            const closepanelPromise = new Promise((resolve) => {
                const endWrapperTransition = (evt) => {
                    if (this.menuMobileClosePanel.classList.contains('opening')) {
                        this.menuMobileClosePanel.classList.remove('opening', 'closed');
                        this.menuMobileClosePanel.removeEventListener('transitionend', endWrapperTransition);
                        resolve(true);
                    }
                };
                this.menuMobileClosePanel.addEventListener('transitionend', endWrapperTransition);
                this.menuMobileClosePanel.classList.remove('closed');
                this.menuMobileClosePanel.classList.add('opening', 'opened');
            });
            animationPromises.push(closepanelPromise);
            return Promise.all(animationPromises);
        })
            .then((result) => {
            this.ea.publish(Menu_1.channel, {
                status: _interfaces_menu__WEBPACK_IMPORTED_MODULE_1__.MenuStatus.OPENED
            });
            return result.reduce((acc, el) => {
                return el && acc;
            }, true);
        });
    }
    closeWithTransition() {
        this.ea.publish(Menu_1.channel, {
            status: _interfaces_menu__WEBPACK_IMPORTED_MODULE_1__.MenuStatus.CLOSING
        });
        const animationPromise = new Promise((resolve) => {
            setTimeout(() => {
                resolve(true);
            });
        });
        return animationPromise
            .then((status) => {
            const animationPromises = [];
            const overlayPromise = new Promise((resolve) => {
                const endWrapperTransition = (evt) => {
                    if (this.menuMobileOverlay.classList.contains('closing')) {
                        this.menuMobileOverlay.classList.remove('closing', 'opened');
                        this.menuMobileOverlay.removeEventListener('transitionend', endWrapperTransition);
                        resolve(true);
                    }
                };
                this.menuMobileOverlay.addEventListener('transitionend', endWrapperTransition);
                this.menuMobileOverlay.classList.remove('opened');
                this.menuMobileOverlay.classList.add('closing', 'closed');
            });
            animationPromises.push(overlayPromise);
            const offcanvasPromise = new Promise((resolve) => {
                const endWrapperTransition = (evt) => {
                    if (this.menuMobileOffcanvas.classList.contains('closing')) {
                        this.menuMobileOffcanvas.classList.remove('closing', 'opened');
                        this.menuMobileOffcanvas.removeEventListener('transitionend', endWrapperTransition);
                        resolve(true);
                    }
                };
                this.menuMobileOffcanvas.addEventListener('transitionend', endWrapperTransition);
                this.menuMobileOffcanvas.classList.remove('opened');
                this.menuMobileOffcanvas.classList.add('closing', 'closed');
            });
            animationPromises.push(offcanvasPromise);
            const closepanelPromise = new Promise((resolve) => {
                const endWrapperTransition = (evt) => {
                    if (this.menuMobileClosePanel.classList.contains('closing')) {
                        this.menuMobileClosePanel.classList.remove('closing', 'opened');
                        this.menuMobileClosePanel.removeEventListener('transitionend', endWrapperTransition);
                        resolve(true);
                    }
                };
                this.menuMobileClosePanel.addEventListener('transitionend', endWrapperTransition);
                this.menuMobileClosePanel.classList.remove('opened');
                this.menuMobileClosePanel.classList.add('closing', 'closed');
            });
            animationPromises.push(closepanelPromise);
            return Promise.all(animationPromises);
        })
            .then((result) => {
            this.ea.publish(Menu_1.channel, {
                status: _interfaces_menu__WEBPACK_IMPORTED_MODULE_1__.MenuStatus.CLOSED
            });
            this.element.style.display = 'none';
            return result.reduce((acc, el) => {
                return el && acc;
            }, true);
        });
    }
};
Menu.channel = 'Menu';
Menu = Menu_1 = __decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.customAttribute)('blackcube-menu'),
    __param(0, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__.ILogger),
    __param(1, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__.IEventAggregator),
    __param(2, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.IPlatform),
    __param(4, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.INode),
    __metadata("design:paramtypes", [Object, Object, Object, _services_StorageService__WEBPACK_IMPORTED_MODULE_2__.StorageService,
        HTMLElement])
], Menu);



/***/ }),

/***/ "./app/attributes/notification-trigger.ts":
/*!************************************************!*\
  !*** ./app/attributes/notification-trigger.ts ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "NotificationTrigger": () => (/* binding */ NotificationTrigger)
/* harmony export */ });
/* harmony import */ var _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/kernel */ "../../../../node_modules/@aurelia/kernel/dist/esm/index.js");
/* harmony import */ var _components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components */ "./app/components/index.ts");
/* harmony import */ var _interfaces_notification__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../interfaces/notification */ "./app/interfaces/notification.ts");
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! aurelia */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");
/* harmony import */ var _interfaces_overlay__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../interfaces/overlay */ "./app/interfaces/overlay.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (undefined && undefined.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};






// @customAttribute({name: 'blackcube-notification-trigger', aliases:['bc-nt']})
let NotificationTrigger = class NotificationTrigger {
    constructor(logger, ea, platform, element) {
        this.logger = logger;
        this.ea = ea;
        this.platform = platform;
        this.element = element;
        this.title = '';
        this.type = _interfaces_notification__WEBPACK_IMPORTED_MODULE_2__.NotificationType.CHECK;
        this.content = '';
        this.duration = 5000;
        this.closeOverlay = false;
        this.logger = logger.scopeTo('NotificationTrigger');
        this.logger.trace('constructor');
    }
    attaching() {
        this.logger.trace('Attaching');
    }
    attached() {
        this.logger.trace('Send Notification');
        this.platform.taskQueue.queueTask(() => {
            this.ea.publish(_components__WEBPACK_IMPORTED_MODULE_1__.NotificationCenter.channel, {
                type: _interfaces_notification__WEBPACK_IMPORTED_MODULE_2__.NotificationCenterEventType.CREATE,
                notification: {
                    title: this.title,
                    type: this.type,
                    content: this.content,
                    duration: this.duration
                }
            });
            if (this.closeOverlay) {
                this.ea.publish(_components__WEBPACK_IMPORTED_MODULE_1__.Overlay.channel, {
                    type: _interfaces_overlay__WEBPACK_IMPORTED_MODULE_3__.OverlayEventType.CLOSE
                });
            }
        });
    }
};
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.bindable)(),
    __metadata("design:type", String)
], NotificationTrigger.prototype, "title", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.bindable)(),
    __metadata("design:type", String)
], NotificationTrigger.prototype, "type", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.bindable)(),
    __metadata("design:type", String)
], NotificationTrigger.prototype, "content", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.bindable)(),
    __metadata("design:type", Number)
], NotificationTrigger.prototype, "duration", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.bindable)(),
    __metadata("design:type", Boolean)
], NotificationTrigger.prototype, "closeOverlay", void 0);
NotificationTrigger = __decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.customAttribute)('blackcube-notification-trigger'),
    __param(0, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__.ILogger),
    __param(1, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__.IEventAggregator),
    __param(2, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.IPlatform),
    __param(3, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.INode),
    __metadata("design:paramtypes", [Object, Object, Object, HTMLElement])
], NotificationTrigger);



/***/ }),

/***/ "./app/attributes/overlay-close.ts":
/*!*****************************************!*\
  !*** ./app/attributes/overlay-close.ts ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "OverlayClose": () => (/* binding */ OverlayClose)
/* harmony export */ });
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");
/* harmony import */ var _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/kernel */ "../../../../node_modules/@aurelia/kernel/dist/esm/index.js");
/* harmony import */ var _components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components */ "./app/components/index.ts");
/* harmony import */ var _interfaces_overlay__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../interfaces/overlay */ "./app/interfaces/overlay.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (undefined && undefined.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};




let OverlayClose = class OverlayClose {
    constructor(logger, ea, element) {
        this.logger = logger;
        this.ea = ea;
        this.element = element;
        this.logger = logger.scopeTo('OverlayClose');
    }
    attached() {
        this.logger.trace('Attaching');
        this.ea.publish(_components__WEBPACK_IMPORTED_MODULE_1__.Overlay.channel, {
            type: _interfaces_overlay__WEBPACK_IMPORTED_MODULE_2__.OverlayEventType.CLOSE,
        });
    }
};
OverlayClose = __decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.customAttribute)('blackcube-overlay-close'),
    __param(0, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__.ILogger),
    __param(1, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__.IEventAggregator),
    __param(2, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.INode),
    __metadata("design:paramtypes", [Object, Object, HTMLElement])
], OverlayClose);



/***/ }),

/***/ "./app/attributes/overlay-trigger.ts":
/*!*******************************************!*\
  !*** ./app/attributes/overlay-trigger.ts ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "OverlayTrigger": () => (/* binding */ OverlayTrigger)
/* harmony export */ });
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");
/* harmony import */ var _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/kernel */ "../../../../node_modules/@aurelia/kernel/dist/esm/index.js");
/* harmony import */ var _components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components */ "./app/components/index.ts");
/* harmony import */ var _interfaces_overlay__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../interfaces/overlay */ "./app/interfaces/overlay.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (undefined && undefined.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};




let OverlayTrigger = class OverlayTrigger {
    constructor(logger, ea, element) {
        this.logger = logger;
        this.ea = ea;
        this.element = element;
        this.onClick = (event) => {
            this.logger.debug('onClickOverlay');
            event.preventDefault();
            this.ea.publish(_components__WEBPACK_IMPORTED_MODULE_1__.Overlay.channel, {
                type: _interfaces_overlay__WEBPACK_IMPORTED_MODULE_2__.OverlayEventType.OPEN,
                overlay: {
                    title: this.title,
                    abstract: this.abstract,
                    url: this.url,
                    cancelTitle: this.cancelTitle,
                    actionTitle: this.actionTitle
                }
            });
        };
        this.logger = logger.scopeTo('OverlayTrigger');
    }
    attaching() {
        this.logger.trace('Attaching');
    }
    attached() {
        this.logger.trace('Attached');
        this.element.addEventListener('click', this.onClick);
    }
    detaching() {
        this.logger.trace('Detaching');
        this.element.removeEventListener('click', this.onClick);
    }
};
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.bindable)(),
    __metadata("design:type", String)
], OverlayTrigger.prototype, "title", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.bindable)(),
    __metadata("design:type", String)
], OverlayTrigger.prototype, "abstract", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.bindable)(),
    __metadata("design:type", String)
], OverlayTrigger.prototype, "url", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.bindable)(),
    __metadata("design:type", String)
], OverlayTrigger.prototype, "actionTitle", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.bindable)(),
    __metadata("design:type", String)
], OverlayTrigger.prototype, "cancelTitle", void 0);
OverlayTrigger = __decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.customAttribute)('blackcube-overlay-trigger'),
    __param(0, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__.ILogger),
    __param(1, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__.IEventAggregator),
    __param(2, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.INode),
    __metadata("design:paramtypes", [Object, Object, HTMLElement])
], OverlayTrigger);



/***/ }),

/***/ "./app/attributes/toggle-dependencies.ts":
/*!***********************************************!*\
  !*** ./app/attributes/toggle-dependencies.ts ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ToggleDependencies": () => (/* binding */ ToggleDependencies)
/* harmony export */ });
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");
/* harmony import */ var _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/kernel */ "../../../../node_modules/@aurelia/kernel/dist/esm/index.js");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (undefined && undefined.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};


let ToggleDependencies = class ToggleDependencies {
    constructor(logger, ea, element) {
        this.logger = logger;
        this.ea = ea;
        this.element = element;
        this.target = 'data-dependency';
        this.source = 'data-dependency-source';
        this.onChange = (item) => {
            let toggle = item.currentTarget;
            if (toggle.checked) {
                this.activateFields();
            }
            else {
                this.deactivateFields();
            }
        };
        this.logger = logger.scopeTo('ToggleDependencies');
    }
    attached() {
        this.toggleElement = this.element.querySelector('[' + this.source + ']');
        if (this.toggleElement) {
            this.toggleTargets = this.element.querySelectorAll('[' + this.target + ']');
            if (this.toggleElement.checked) {
                this.activateFields();
            }
            else {
                this.deactivateFields();
            }
            this.toggleElement.addEventListener('change', this.onChange);
        }
    }
    detaching() {
        if (this.toggleElement) {
            this.toggleElement.removeEventListener('change', this.onChange);
        }
    }
    activateFields() {
        this.toggleTargets.forEach((item) => {
            item.classList.remove('opacity-50');
            item.querySelectorAll('input, select').forEach((item) => {
                item.disabled = false;
            });
        });
    }
    deactivateFields() {
        this.toggleTargets.forEach((item) => {
            item.classList.add('opacity-50');
            item.querySelectorAll('input, select').forEach((item) => {
                item.disabled = true;
            });
        });
    }
};
ToggleDependencies = __decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_1__.customAttribute)('blackcube-toggle-dependencies'),
    __param(0, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__.ILogger),
    __param(1, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__.IEventAggregator),
    __param(2, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_1__.INode),
    __metadata("design:paramtypes", [Object, Object, HTMLElement])
], ToggleDependencies);



/***/ }),

/***/ "./app/components/alert.ts":
/*!*********************************!*\
  !*** ./app/components/alert.ts ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Alert": () => (/* binding */ Alert)
/* harmony export */ });
/* harmony import */ var _alert_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./alert.html */ "./app/components/alert.html");
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");
/* harmony import */ var _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @aurelia/kernel */ "../../../../node_modules/@aurelia/kernel/dist/esm/index.js");
/* harmony import */ var _interfaces_alert__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../interfaces/alert */ "./app/interfaces/alert.ts");
/* harmony import */ var _helpers_transition__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../helpers/transition */ "./app/helpers/transition.ts");
/* harmony import */ var _services_http_service__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../services/http-service */ "./app/services/http-service.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (undefined && undefined.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};
var Alert_1;






let Alert = Alert_1 = class Alert {
    constructor(logger, ea, httpService, element) {
        this.logger = logger;
        this.ea = ea;
        this.httpService = httpService;
        this.element = element;
        this.alertTypes = _interfaces_alert__WEBPACK_IMPORTED_MODULE_2__.AlertType;
        this.type = _interfaces_alert__WEBPACK_IMPORTED_MODULE_2__.AlertType.QUESTION;
        this.cancelTitle = 'Cancel';
        this.actionTitle = 'Action';
        this.stackedAlerts = [];
        this.alertShown = false;
        this.onAlertEvent = (event) => {
            // this.stackedAlerts.push(event);
            if (event.type === _interfaces_alert__WEBPACK_IMPORTED_MODULE_2__.AlertEventType.OPEN && event.alert) {
                this.type = event.alert.type;
                if (event.alert.actionTitle) {
                    this.actionTitle = event.alert.actionTitle;
                }
                if (event.alert.cancelTitle) {
                    this.cancelTitle = event.alert.cancelTitle;
                }
                this.contentUrl = event.alert.contentUrl;
                this.action = event.alert.action;
                this.cancel = event.alert.cancel;
                this.httpService.getHtmlContent(this.contentUrl)
                    .then((html) => {
                    this.htmlData = html;
                    return true;
                })
                    .then((res) => {
                    this.logger.warn('Opening alert');
                    this.openWithTransition();
                });
            }
            else if (event.type === _interfaces_alert__WEBPACK_IMPORTED_MODULE_2__.AlertEventType.CLOSE) {
                this.closeWithTransition();
            }
        };
        this.logger = logger.scopeTo('Alert');
    }
    attaching() {
        this.logger.trace('Attaching');
        this.element.style.display = 'none';
        this.subscription = this.ea.subscribe(Alert_1.channel, this.onAlertEvent);
    }
    attached() {
        this.logger.trace('Attached');
    }
    detaching() {
        this.logger.trace('Detaching');
    }
    openWithTransition() {
        return (0,_helpers_transition__WEBPACK_IMPORTED_MODULE_3__.transitionWithPromise)({
            element: this.element,
            beforeDisplayStyle: 'inherit',
            startingCallback: () => {
                this.logger.warn('opening');
                this.ea.publish(Alert_1.channel, {
                    status: _interfaces_alert__WEBPACK_IMPORTED_MODULE_2__.AlertStatus.OPENING
                });
            },
            endingCallback: () => {
                this.logger.warn('opened');
                this.ea.publish(Alert_1.channel, {
                    status: _interfaces_alert__WEBPACK_IMPORTED_MODULE_2__.AlertStatus.OPENED
                });
                this.alertShown = true;
            }
        }, [
            { element: this.wrapper, from: ['closed'], to: ['opened'], transition: ['opening'] },
            { element: this.panel, from: ['closed'], to: ['opened'], transition: ['opening'] }
        ]);
    }
    closeWithTransition() {
        return (0,_helpers_transition__WEBPACK_IMPORTED_MODULE_3__.transitionWithPromise)({
            element: this.element,
            afterDisplayStyle: 'none',
            startingCallback: () => {
                this.ea.publish(Alert_1.channel, {
                    status: _interfaces_alert__WEBPACK_IMPORTED_MODULE_2__.AlertStatus.CLOSING
                });
            },
            endingCallback: () => {
                this.ea.publish(Alert_1.channel, {
                    status: _interfaces_alert__WEBPACK_IMPORTED_MODULE_2__.AlertStatus.CLOSED
                });
                this.alertShown = true;
            }
        }, [
            { element: this.wrapper, from: ['opened'], to: ['closed'], transition: ['closing'] },
            { element: this.panel, from: ['opened'], to: ['closed'], transition: ['closing'] }
        ]);
    }
    onClickAction(evt) {
        evt.preventDefault();
        this.logger.debug('Click action');
        if (this.action) {
            this.action();
        }
        this.closeWithTransition();
    }
    onClickCancel(evt) {
        evt.preventDefault();
        this.logger.debug('Click cancel');
        if (this.cancel) {
            this.cancel();
        }
        this.closeWithTransition();
    }
};
Alert.channel = 'Alert';
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.bindable)(),
    __metadata("design:type", String)
], Alert.prototype, "type", void 0);
Alert = Alert_1 = __decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.customElement)(Object.assign(Object.assign({}, _alert_html__WEBPACK_IMPORTED_MODULE_0__), { name: 'blackcube-alert' })),
    __param(0, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__.ILogger),
    __param(1, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__.IEventAggregator),
    __param(3, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.INode),
    __metadata("design:paramtypes", [Object, Object, _services_http_service__WEBPACK_IMPORTED_MODULE_4__.HttpService,
        HTMLElement])
], Alert);



/***/ }),

/***/ "./app/components/blocs.ts":
/*!*********************************!*\
  !*** ./app/components/blocs.ts ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Blocs": () => (/* binding */ Blocs)
/* harmony export */ });
/* harmony import */ var _blocs_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./blocs.html */ "./app/components/blocs.html");
/* harmony import */ var _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @aurelia/kernel */ "../../../../node_modules/@aurelia/kernel/dist/esm/index.js");
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");
/* harmony import */ var _services_http_service__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../services/http-service */ "./app/services/http-service.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (undefined && undefined.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};





let Blocs = class Blocs {
    constructor(logger, platform, httpService, element) {
        this.logger = logger;
        this.platform = platform;
        this.httpService = httpService;
        this.element = element;
        this.view = '';
        this.onDelegateClick = (evt) => {
            if (evt.target) {
                evt.stopPropagation();
                //TODO: make better delegate
                //@ts-ignore
                let currentButton = evt.target.closest('button[type=button]');
                if (currentButton && this.element.contains(currentButton)) {
                    evt.preventDefault();
                    this.logger.debug('delegateClick');
                    if (currentButton.name) {
                        const body = new FormData(this.form);
                        const method = 'post';
                        body.append(currentButton.name, currentButton.value);
                        this.httpService.fetch(this.url, { body, method })
                            .then(response => {
                            return response.text();
                        })
                            .then((html) => {
                            this.view = html;
                        });
                    }
                }
            }
        };
        this.logger = logger.scopeTo('Blocs');
    }
    attached() {
        this.logger.debug('Attached');
        this.logger.debug(this.url);
        this.form = this.element.closest('form');
        this.element.addEventListener('click', this.onDelegateClick);
    }
    detaching() {
        this.logger.debug('Detached');
        this.element.removeEventListener('click', this.onDelegateClick);
    }
};
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.bindable)(),
    __metadata("design:type", String)
], Blocs.prototype, "url", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.bindable)(),
    __metadata("design:type", String)
], Blocs.prototype, "view", void 0);
Blocs = __decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.customElement)(Object.assign(Object.assign({}, _blocs_html__WEBPACK_IMPORTED_MODULE_0__), { name: 'blackcube-blocs' })),
    __param(0, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__.ILogger),
    __param(1, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.IPlatform),
    __param(3, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.INode),
    __metadata("design:paramtypes", [Object, Object, _services_http_service__WEBPACK_IMPORTED_MODULE_2__.HttpService,
        HTMLElement])
], Blocs);



/***/ }),

/***/ "./app/components/burger.ts":
/*!**********************************!*\
  !*** ./app/components/burger.ts ***!
  \**********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Burger": () => (/* binding */ Burger)
/* harmony export */ });
/* harmony import */ var _burger_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./burger.html */ "./app/components/burger.html");
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! aurelia */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");
/* harmony import */ var _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @aurelia/kernel */ "../../../../node_modules/@aurelia/kernel/dist/esm/index.js");
/* harmony import */ var _attributes__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../attributes */ "./app/attributes/index.ts");
/* harmony import */ var _interfaces_menu__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../interfaces/menu */ "./app/interfaces/menu.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (undefined && undefined.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};






let Burger = class Burger {
    constructor(logger, ea, element) {
        this.logger = logger;
        this.ea = ea;
        this.element = element;
        this.onClick = (event) => {
            // this.stackedAlerts.push(event);
            event.preventDefault();
            this.ea.publish(_attributes__WEBPACK_IMPORTED_MODULE_2__.Menu.channel, { type: _interfaces_menu__WEBPACK_IMPORTED_MODULE_3__.MenuEventType.OPEN });
        };
        this.logger = logger.scopeTo('Burger');
    }
    attaching() {
        this.logger.trace('Attaching');
        this.openMenuBtn.addEventListener('click', this.onClick);
    }
    attached() {
        this.logger.trace('Attached');
    }
    detaching() {
        this.logger.trace('Detaching');
        this.openMenuBtn.removeEventListener('click', this.onClick);
    }
};
Burger = __decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.customElement)(Object.assign(Object.assign({}, _burger_html__WEBPACK_IMPORTED_MODULE_0__), { name: 'blackcube-burger' })),
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.containerless)(),
    __param(0, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__.ILogger),
    __param(1, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__.IEventAggregator),
    __param(2, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.INode),
    __metadata("design:paramtypes", [Object, Object, HTMLElement])
], Burger);



/***/ }),

/***/ "./app/components/composites.ts":
/*!**************************************!*\
  !*** ./app/components/composites.ts ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Composites": () => (/* binding */ Composites)
/* harmony export */ });
/* harmony import */ var _composites_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./composites.html */ "./app/components/composites.html");
/* harmony import */ var _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @aurelia/kernel */ "../../../../node_modules/@aurelia/kernel/dist/esm/index.js");
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");
/* harmony import */ var _services_http_service__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../services/http-service */ "./app/services/http-service.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (undefined && undefined.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};





let Composites = class Composites {
    constructor(logger, platform, httpService, element) {
        this.logger = logger;
        this.platform = platform;
        this.httpService = httpService;
        this.element = element;
        this.view = '';
        this.onDelegateClick = (evt) => {
            if (evt.target) {
                evt.stopPropagation();
                //TODO: make better delegate
                //@ts-ignore
                let currentButton = evt.target.closest('button[type=button]');
                if (currentButton && this.element.contains(currentButton)) {
                    evt.preventDefault();
                    this.logger.debug('delegateClick');
                    if (currentButton.name) {
                        const body = new FormData(this.form);
                        const method = 'post';
                        body.append(currentButton.name, currentButton.value);
                        this.httpService.fetch(this.url, { body, method })
                            .then(response => {
                            return response.text();
                        })
                            .then((html) => {
                            this.view = html;
                        });
                    }
                }
            }
        };
        this.logger = logger.scopeTo('Composites');
    }
    attached() {
        this.logger.debug('Attached');
        this.logger.debug(this.url);
        this.form = this.element.closest('form');
        this.element.addEventListener('click', this.onDelegateClick);
    }
    detaching() {
        this.logger.debug('Detached');
        this.element.removeEventListener('click', this.onDelegateClick);
    }
};
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.bindable)(),
    __metadata("design:type", String)
], Composites.prototype, "url", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.bindable)(),
    __metadata("design:type", String)
], Composites.prototype, "view", void 0);
Composites = __decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.customElement)(Object.assign(Object.assign({}, _composites_html__WEBPACK_IMPORTED_MODULE_0__), { name: 'blackcube-composites' })),
    __param(0, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__.ILogger),
    __param(1, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.IPlatform),
    __param(3, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.INode),
    __metadata("design:paramtypes", [Object, Object, _services_http_service__WEBPACK_IMPORTED_MODULE_2__.HttpService,
        HTMLElement])
], Composites);



/***/ }),

/***/ "./app/components/element-toolbar.ts":
/*!*******************************************!*\
  !*** ./app/components/element-toolbar.ts ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ElementToolbar": () => (/* binding */ ElementToolbar)
/* harmony export */ });
/* harmony import */ var _element_toolbar_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./element-toolbar.html */ "./app/components/element-toolbar.html");
/* harmony import */ var _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @aurelia/kernel */ "../../../../node_modules/@aurelia/kernel/dist/esm/index.js");
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");
/* harmony import */ var _services_http_service__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../services/http-service */ "./app/services/http-service.ts");
/* harmony import */ var _overlay__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./overlay */ "./app/components/overlay.ts");
/* harmony import */ var _interfaces_overlay__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../interfaces/overlay */ "./app/interfaces/overlay.ts");
/* harmony import */ var _interfaces_broadcast__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../interfaces/broadcast */ "./app/interfaces/broadcast.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (undefined && undefined.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};








let ElementToolbar = class ElementToolbar {
    constructor(logger, ea, platform, httpService, element) {
        this.logger = logger;
        this.ea = ea;
        this.platform = platform;
        this.httpService = httpService;
        this.element = element;
        this.slugTitle = 'Slug';
        this.slugActive = false;
        this.slugExists = false;
        this.sitemapTitle = 'Sitemap';
        this.sitemapActive = false;
        this.seoTitle = 'SEO';
        this.seoActive = false;
        this.showTags = true;
        this.tagsTitle = 'Tags';
        this.onEvent = (event) => {
            var _a, _b, _c;
            if (((_a = event.data) === null || _a === void 0 ? void 0 : _a.type) === 'slug') {
                if (event.type === _interfaces_broadcast__WEBPACK_IMPORTED_MODULE_5__.BroadcastElementEventType.CREATE || event.type === _interfaces_broadcast__WEBPACK_IMPORTED_MODULE_5__.BroadcastElementEventType.UPDATE) {
                    this.slugExists = true;
                }
                else if (event.type === _interfaces_broadcast__WEBPACK_IMPORTED_MODULE_5__.BroadcastElementEventType.DELETE) {
                    this.slugExists = false;
                    this.slugActive = false;
                    this.seoActive = false;
                    this.sitemapActive = false;
                }
                if (event.type === _interfaces_broadcast__WEBPACK_IMPORTED_MODULE_5__.BroadcastElementEventType.ACTIVATE) {
                    this.slugActive = true;
                }
                else if (event.type === _interfaces_broadcast__WEBPACK_IMPORTED_MODULE_5__.BroadcastElementEventType.DEACTIVATE) {
                    this.slugActive = false;
                }
            }
            if (((_b = event.data) === null || _b === void 0 ? void 0 : _b.type) === 'seo') {
                if (event.type === _interfaces_broadcast__WEBPACK_IMPORTED_MODULE_5__.BroadcastElementEventType.ACTIVATE) {
                    this.seoActive = true;
                }
                else if (event.type === _interfaces_broadcast__WEBPACK_IMPORTED_MODULE_5__.BroadcastElementEventType.DEACTIVATE) {
                    this.seoActive = false;
                }
            }
            if (((_c = event.data) === null || _c === void 0 ? void 0 : _c.type) === 'sitemap') {
                if (event.type === _interfaces_broadcast__WEBPACK_IMPORTED_MODULE_5__.BroadcastElementEventType.ACTIVATE) {
                    this.sitemapActive = true;
                }
                else if (event.type === _interfaces_broadcast__WEBPACK_IMPORTED_MODULE_5__.BroadcastElementEventType.DEACTIVATE) {
                    this.sitemapActive = false;
                }
            }
        };
        this.logger = logger.scopeTo('ElementToolbar');
    }
    attaching() {
        this.eventListener = this.ea.subscribe(_interfaces_broadcast__WEBPACK_IMPORTED_MODULE_5__.Broadcast.channel, this.onEvent);
    }
    attached() {
        this.logger.debug('Attached');
    }
    detaching() {
        this.logger.debug('Detached');
    }
    dispose() {
        this.eventListener.dispose();
    }
    onClickSlug(event) {
        event.preventDefault();
        this.ea.publish(_overlay__WEBPACK_IMPORTED_MODULE_3__.Overlay.channel, {
            type: _interfaces_overlay__WEBPACK_IMPORTED_MODULE_4__.OverlayEventType.OPEN,
            overlay: {
                url: this.slugUrl,
            }
        });
    }
    onClickSitemap(event) {
        event.preventDefault();
        if (this.slugExists) {
            this.ea.publish(_overlay__WEBPACK_IMPORTED_MODULE_3__.Overlay.channel, {
                type: _interfaces_overlay__WEBPACK_IMPORTED_MODULE_4__.OverlayEventType.OPEN,
                overlay: {
                    url: this.sitemapUrl,
                }
            });
        }
    }
    onClickSeo(event) {
        event.preventDefault();
        if (this.slugExists) {
            this.ea.publish(_overlay__WEBPACK_IMPORTED_MODULE_3__.Overlay.channel, {
                type: _interfaces_overlay__WEBPACK_IMPORTED_MODULE_4__.OverlayEventType.OPEN,
                overlay: {
                    url: this.seoUrl,
                }
            });
        }
    }
    onClickTags(event) {
        event.preventDefault();
        this.ea.publish(_overlay__WEBPACK_IMPORTED_MODULE_3__.Overlay.channel, {
            type: _interfaces_overlay__WEBPACK_IMPORTED_MODULE_4__.OverlayEventType.OPEN,
            overlay: {
                url: this.tagsUrl,
            }
        });
    }
};
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_6__.bindable)(),
    __metadata("design:type", String)
], ElementToolbar.prototype, "slugTitle", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_6__.bindable)(),
    __metadata("design:type", String)
], ElementToolbar.prototype, "slugUrl", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_6__.bindable)(),
    __metadata("design:type", Boolean)
], ElementToolbar.prototype, "slugActive", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_6__.bindable)(),
    __metadata("design:type", Boolean)
], ElementToolbar.prototype, "slugExists", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_6__.bindable)(),
    __metadata("design:type", String)
], ElementToolbar.prototype, "sitemapTitle", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_6__.bindable)(),
    __metadata("design:type", String)
], ElementToolbar.prototype, "sitemapUrl", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_6__.bindable)(),
    __metadata("design:type", Boolean)
], ElementToolbar.prototype, "sitemapActive", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_6__.bindable)(),
    __metadata("design:type", String)
], ElementToolbar.prototype, "seoTitle", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_6__.bindable)(),
    __metadata("design:type", String)
], ElementToolbar.prototype, "seoUrl", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_6__.bindable)(),
    __metadata("design:type", Boolean)
], ElementToolbar.prototype, "seoActive", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_6__.bindable)(),
    __metadata("design:type", Boolean)
], ElementToolbar.prototype, "showTags", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_6__.bindable)(),
    __metadata("design:type", String)
], ElementToolbar.prototype, "tagsTitle", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_6__.bindable)(),
    __metadata("design:type", String)
], ElementToolbar.prototype, "tagsUrl", void 0);
ElementToolbar = __decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_6__.customElement)(Object.assign(Object.assign({}, _element_toolbar_html__WEBPACK_IMPORTED_MODULE_0__), { name: 'blackcube-element-toolbar' })),
    __param(0, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__.ILogger),
    __param(1, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__.IEventAggregator),
    __param(2, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_6__.IPlatform),
    __param(4, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_6__.INode),
    __metadata("design:paramtypes", [Object, Object, Object, _services_http_service__WEBPACK_IMPORTED_MODULE_2__.HttpService,
        HTMLElement])
], ElementToolbar);



/***/ }),

/***/ "./app/components/file.ts":
/*!********************************!*\
  !*** ./app/components/file.ts ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "File": () => (/* binding */ File)
/* harmony export */ });
/* harmony import */ var _file_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./file.html */ "./app/components/file.html");
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! aurelia */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");
/* harmony import */ var _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @aurelia/kernel */ "../../../../node_modules/@aurelia/kernel/dist/esm/index.js");
/* harmony import */ var resumablejs__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! resumablejs */ "../../../../node_modules/resumablejs/resumable.js");
/* harmony import */ var resumablejs__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(resumablejs__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var urijs__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! urijs */ "../../../../node_modules/urijs/src/URI.js");
/* harmony import */ var urijs__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(urijs__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _services_http_service__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../services/http-service */ "./app/services/http-service.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (undefined && undefined.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};







let File = class File {
    constructor(logger, httpService, platform, element) {
        this.logger = logger;
        this.httpService = httpService;
        this.platform = platform;
        this.element = element;
        this.uploadCount = 0;
        this.fileType = '';
        this.multiple = false;
        this.value = '';
        this.error = false;
        this.onDragEnter = (evt) => {
            evt.preventDefault();
            let el = evt.currentTarget;
            let dt = evt.dataTransfer;
            if (dt && dt.types.indexOf('Files') >= 0) {
                evt.stopPropagation();
                dt.dropEffect = 'copy';
                dt.effectAllowed = 'copy';
                el.classList.add('border-green-700');
            }
            else if (dt) {
                dt.dropEffect = 'none';
                dt.effectAllowed = 'none';
            }
        };
        this.onDragLeave = (evt) => {
            let el = evt.currentTarget;
            el.classList.remove('border-green-700');
        };
        this.onFileAdded = (file, event) => {
            this.logger.debug('onFileAdded', file, event);
            this.error = false;
            this.resumable.upload();
        };
        // File upload completed
        this.onFileSuccess = (file, serverMessage) => {
            const response = JSON.parse(serverMessage);
            if (this.multiple === false) {
                this.setFile('@blackcubetmp/' + response.finalFilename, file);
            }
            else {
                this.appendFile('@blackcubetmp/' + response.finalFilename, file);
            }
            this.logger.debug('onFileSuccess', file, serverMessage);
        };
        // File upload progress
        this.onFileProgress = (file, serverMessage) => {
            this.logger.debug('onFileProgress', file, serverMessage);
        };
        this.onFilesAdded = (filesAdded, filesSkipped) => {
            this.logger.debug('onFilesAdded', filesAdded, filesSkipped);
        };
        this.onFileRetry = (file) => {
            this.logger.debug('onFileRetry', file);
        };
        this.onFileError = (file, serverMessage) => {
            this.logger.debug('onFileError', file, serverMessage);
        };
        this.onUploadStart = () => {
            this.logger.debug('onUploadStart');
            this.handleUploadIcon(1);
        };
        this.onComplete = () => {
            this.logger.debug('onComplete');
            this.handleUploadIcon(-1);
        };
        this.onProgress = () => {
            this.logger.debug('onProgress');
        };
        this.onError = (serverMessage, file) => {
            this.logger.debug('onError', file, serverMessage);
        };
        this.onPause = () => {
            this.logger.debug('onPause');
        };
        this.onBeforeCancel = () => {
            this.logger.debug('onBeforeCancel');
        };
        this.onCancel = () => {
            this.logger.debug('onCancel');
            this.handleUploadIcon(-1);
        };
        this.onChunkingStart = (file) => {
            this.logger.debug('onChunkingStart', file);
        };
        this.onChunkingProgress = (file, ratio) => {
            this.logger.debug('onChunkingProgressd', file, ratio);
        };
        this.onChunkingComplete = (file) => {
            this.logger.debug('onChunkingComplete', file);
        };
        this.logger = logger.scopeTo('File');
    }
    appendParametersUrl(url) {
        let baseUrl = new (urijs__WEBPACK_IMPORTED_MODULE_3___default())(url);
        if (this.imageWidth) {
            baseUrl.addSearch({ width: this.imageWidth });
        }
        if (this.imageHeight) {
            baseUrl.addSearch({ height: this.imageHeight });
        }
        return baseUrl.toString();
    }
    generatePreviewUrl(name) {
        let url = this.previewUrl.replace('__name__', name);
        return this.appendParametersUrl(url);
    }
    generateDeleteUrl(name) {
        return this.deleteUrl.replace('__name__', name);
    }
    setFiles(value) {
        let files = value.split(/\s*,\s*/);
        this.handledFiles = files.filter((value, index) => {
            return value.trim() !== '';
        }).map((value, index) => {
            return {
                name: value,
                shortname: value.split(/.*[\/|\\]/).pop(),
                previewUrl: this.generatePreviewUrl(value),
                deleteUrl: this.generateDeleteUrl(value)
            };
        });
        this.hiddenField.value = this.getFilesValue();
    }
    setFile(name, file = null) {
        this.handledFiles.forEach((handledFile, index) => {
            if (handledFile.file && handledFile.file !== null) {
                this.resumable.removeFile(handledFile.file);
            }
            this.httpService.deleteRequest(handledFile.deleteUrl, this.csfr.value);
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
    }
    appendFile(name, file = null) {
        this.handledFiles.push({
            name: name,
            shortname: name.split(/.*[\/|\\]/).pop(),
            previewUrl: this.generatePreviewUrl(name),
            deleteUrl: this.generateDeleteUrl(name),
            file: file
        });
        this.hiddenField.value = this.getFilesValue();
    }
    getFilesValue() {
        let mapped = this.handledFiles.map((uploadedFile, index) => {
            return uploadedFile.name;
        }).join(', ');
        return (typeof mapped === 'string') ? mapped : '';
    }
    onRemove(handledFile, evt) {
        evt.stopPropagation();
        evt.preventDefault();
        this.logger.debug('Should remove file', handledFile);
        let fileIndex = null;
        this.handledFiles.forEach((file, index) => {
            if (handledFile.name === file.name) {
                fileIndex = index;
            }
        });
        if (fileIndex !== null && fileIndex >= 0) {
            if (handledFile.file && handledFile.file !== null) {
                this.resumable.removeFile(handledFile.file);
            }
            this.handledFiles.splice(fileIndex, 1);
            this.httpService.deleteRequest(handledFile.deleteUrl, this.csfr.value);
            // should call WS delete
        }
        let fieldValue = this.getFilesValue();
        this.hiddenField.value = fieldValue;
    }
    ;
    attached() {
        this.setUp();
    }
    setUp() {
        this.parentForm = this.element.closest('form');
        this.logger.debug('Multiple', this.multiple);
        let resumableConfig = {
            target: this.uploadUrl,
            chunkSize: 512 * 1024
        };
        let fileTypes = this.fileType.split(/\s*,\s*/).filter((value, index) => {
            return value.trim() !== '';
        });
        this.fileInfo = fileTypes.map((item) => { return item.toLocaleUpperCase(); }).join(', ');
        resumableConfig.fileType = fileTypes;
        if (this.parentForm) {
            let csrfField = this.parentForm.querySelector('input[name=_csrf]');
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
        this.resumable = new (resumablejs__WEBPACK_IMPORTED_MODULE_2___default())(resumableConfig);
        if (this.resumable.support) {
            // this.logger.debug('Resume js supported', this.browse);
            this.resumable.assignBrowse(this.browse, false);
            this.resumable.assignDrop(this.drop);
            this.drop.addEventListener('dragover', this.onDragEnter);
            this.drop.addEventListener('dragenter', this.onDragEnter);
            this.drop.addEventListener('dragleave', this.onDragLeave);
            this.drop.addEventListener('drop', this.onDragLeave);
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
    }
    handleUploadIcon(count) {
        this.uploadCount = this.uploadCount + count;
        /**/
        if (this.uploadCount > 0) {
            this.icon.classList.add('animate-ping');
        }
        else {
            this.icon.classList.remove('animate-ping');
        }
        /**/
    }
    get getFiles() {
        if (this.resumable.support) {
            return this.resumable.files.map((file, index) => {
                return file.fileName;
            });
        }
        return [];
    }
    detaching() {
        if (this.resumable.support) {
            this.drop.removeEventListener('dragover', this.onDragEnter);
            this.drop.removeEventListener('dragenter', this.onDragEnter);
            this.drop.removeEventListener('dragleave', this.onDragLeave);
            this.drop.removeEventListener('drop', this.onDragLeave);
        }
    }
};
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.bindable)(),
    __metadata("design:type", String)
], File.prototype, "uploadUrl", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.bindable)(),
    __metadata("design:type", String)
], File.prototype, "previewUrl", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.bindable)(),
    __metadata("design:type", String)
], File.prototype, "deleteUrl", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.bindable)(),
    __metadata("design:type", String)
], File.prototype, "fileType", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.bindable)(),
    __metadata("design:type", String)
], File.prototype, "name", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.bindable)(),
    __metadata("design:type", Object)
], File.prototype, "multiple", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.bindable)(),
    __metadata("design:type", String)
], File.prototype, "value", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.bindable)(),
    __metadata("design:type", String)
], File.prototype, "imageWidth", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.bindable)(),
    __metadata("design:type", String)
], File.prototype, "imageHeight", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.bindable)(),
    __metadata("design:type", String)
], File.prototype, "title", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.bindable)(),
    __metadata("design:type", String)
], File.prototype, "uploadFileText", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.bindable)(),
    __metadata("design:type", String)
], File.prototype, "uploadFileDnd", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.bindable)(),
    __metadata("design:type", String)
], File.prototype, "uploadFileDescription", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.bindable)(),
    __metadata("design:type", Boolean)
], File.prototype, "error", void 0);
File = __decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.customElement)(Object.assign(Object.assign({}, _file_html__WEBPACK_IMPORTED_MODULE_0__), { name: 'blackcube-file-upload' })),
    __param(0, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__.ILogger),
    __param(2, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.IPlatform),
    __param(3, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.INode),
    __metadata("design:paramtypes", [Object, _services_http_service__WEBPACK_IMPORTED_MODULE_4__.HttpService, Object, Element])
], File);



/***/ }),

/***/ "./app/components/index.ts":
/*!*********************************!*\
  !*** ./app/components/index.ts ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Alert": () => (/* reexport safe */ _alert__WEBPACK_IMPORTED_MODULE_3__.Alert),
/* harmony export */   "Blocs": () => (/* reexport safe */ _blocs__WEBPACK_IMPORTED_MODULE_8__.Blocs),
/* harmony export */   "Burger": () => (/* reexport safe */ _burger__WEBPACK_IMPORTED_MODULE_5__.Burger),
/* harmony export */   "Composites": () => (/* reexport safe */ _composites__WEBPACK_IMPORTED_MODULE_9__.Composites),
/* harmony export */   "ElementToolbar": () => (/* reexport safe */ _element_toolbar__WEBPACK_IMPORTED_MODULE_10__.ElementToolbar),
/* harmony export */   "File": () => (/* reexport safe */ _file__WEBPACK_IMPORTED_MODULE_7__.File),
/* harmony export */   "Notification": () => (/* reexport safe */ _notification__WEBPACK_IMPORTED_MODULE_2__.Notification),
/* harmony export */   "NotificationCenter": () => (/* reexport safe */ _notification_center__WEBPACK_IMPORTED_MODULE_1__.NotificationCenter),
/* harmony export */   "Overlay": () => (/* reexport safe */ _overlay__WEBPACK_IMPORTED_MODULE_4__.Overlay),
/* harmony export */   "Permissions": () => (/* reexport safe */ _permissions__WEBPACK_IMPORTED_MODULE_11__.Permissions),
/* harmony export */   "Profile": () => (/* reexport safe */ _profile__WEBPACK_IMPORTED_MODULE_0__.Profile),
/* harmony export */   "QuillEditor": () => (/* reexport safe */ _quill_editor__WEBPACK_IMPORTED_MODULE_13__.QuillEditor),
/* harmony export */   "SchemaEditor": () => (/* reexport safe */ _schema_editor__WEBPACK_IMPORTED_MODULE_12__.SchemaEditor),
/* harmony export */   "Test": () => (/* reexport safe */ _test__WEBPACK_IMPORTED_MODULE_6__.Test)
/* harmony export */ });
/* harmony import */ var _profile__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./profile */ "./app/components/profile.ts");
/* harmony import */ var _notification_center__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./notification-center */ "./app/components/notification-center.ts");
/* harmony import */ var _notification__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./notification */ "./app/components/notification.ts");
/* harmony import */ var _alert__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./alert */ "./app/components/alert.ts");
/* harmony import */ var _overlay__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./overlay */ "./app/components/overlay.ts");
/* harmony import */ var _burger__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./burger */ "./app/components/burger.ts");
/* harmony import */ var _test__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./test */ "./app/components/test.ts");
/* harmony import */ var _file__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./file */ "./app/components/file.ts");
/* harmony import */ var _blocs__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./blocs */ "./app/components/blocs.ts");
/* harmony import */ var _composites__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./composites */ "./app/components/composites.ts");
/* harmony import */ var _element_toolbar__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./element-toolbar */ "./app/components/element-toolbar.ts");
/* harmony import */ var _permissions__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ./permissions */ "./app/components/permissions.ts");
/* harmony import */ var _schema_editor__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ./schema-editor */ "./app/components/schema-editor.ts");
/* harmony import */ var _quill_editor__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! ./quill-editor */ "./app/components/quill-editor.ts");
















/***/ }),

/***/ "./app/components/notification-center.ts":
/*!***********************************************!*\
  !*** ./app/components/notification-center.ts ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "NotificationCenter": () => (/* binding */ NotificationCenter)
/* harmony export */ });
/* harmony import */ var _notification_center_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./notification-center.html */ "./app/components/notification-center.html");
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");
/* harmony import */ var _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @aurelia/kernel */ "../../../../node_modules/@aurelia/kernel/dist/esm/index.js");
/* harmony import */ var _notification__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./notification */ "./app/components/notification.ts");
/* harmony import */ var _interfaces_notification__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../interfaces/notification */ "./app/interfaces/notification.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (undefined && undefined.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};
var NotificationCenter_1;





let NotificationCenter = NotificationCenter_1 = class NotificationCenter {
    constructor(logger, ea, element) {
        this.logger = logger;
        this.ea = ea;
        this.element = element;
        this.notifications = [];
        this.onNotificationEvent = (event) => {
            if (event.status === _interfaces_notification__WEBPACK_IMPORTED_MODULE_3__.NotificationStatus.CLOSED) {
                this.logger.debug('Notification event', event);
                this.removeNotification(event.index);
            }
        };
        this.onNotificationCenterEvent = (event) => {
            if (event.type === _interfaces_notification__WEBPACK_IMPORTED_MODULE_3__.NotificationCenterEventType.CREATE && event.notification) {
                this.logger.debug('Notification event', event);
                this.addNotification(event.notification);
            }
            else if (event.type === _interfaces_notification__WEBPACK_IMPORTED_MODULE_3__.NotificationCenterEventType.REMOVE_ALL) {
                this.logger.debug('Should close children');
                this.notifications.splice(0, this.notifications.length);
            }
        };
        this.logger = logger.scopeTo('NotificationCenter');
    }
    attaching() {
        this.logger.trace('Attaching');
        this.subscriberNotification = this.ea.subscribe(_notification__WEBPACK_IMPORTED_MODULE_2__.Notification.channel, this.onNotificationEvent);
        this.subscriber = this.ea.subscribe(NotificationCenter_1.channel, this.onNotificationCenterEvent);
    }
    attached() {
        this.logger.trace('Attached');
    }
    dispose() {
        this.subscriberNotification.dispose();
        this.subscriber.dispose();
    }
    addNotification(notification) {
        this.notifications.push(notification);
    }
    removeNotification(index) {
        this.notifications.splice(index, 1);
    }
    detaching() {
        this.logger.trace('Detaching');
    }
};
NotificationCenter.channel = 'NotificationCenter';
NotificationCenter = NotificationCenter_1 = __decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.customElement)(Object.assign(Object.assign({}, _notification_center_html__WEBPACK_IMPORTED_MODULE_0__), { name: 'blackcube-notification-center' })),
    __param(0, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__.ILogger),
    __param(1, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__.IEventAggregator),
    __param(2, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.INode),
    __metadata("design:paramtypes", [Object, Object, HTMLElement])
], NotificationCenter);



/***/ }),

/***/ "./app/components/notification.ts":
/*!****************************************!*\
  !*** ./app/components/notification.ts ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Notification": () => (/* binding */ Notification)
/* harmony export */ });
/* harmony import */ var _notification_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./notification.html */ "./app/components/notification.html");
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! aurelia */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");
/* harmony import */ var _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @aurelia/kernel */ "../../../../node_modules/@aurelia/kernel/dist/esm/index.js");
/* harmony import */ var _interfaces_notification__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../interfaces/notification */ "./app/interfaces/notification.ts");
/* harmony import */ var _helpers_transition__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../helpers/transition */ "./app/helpers/transition.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (undefined && undefined.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};
var Notification_1;






let Notification = Notification_1 = class Notification {
    constructor(logger, ea, platform, element) {
        this.logger = logger;
        this.ea = ea;
        this.platform = platform;
        this.element = element;
        this.notificationTypes = _interfaces_notification__WEBPACK_IMPORTED_MODULE_2__.NotificationType;
        this.type = _interfaces_notification__WEBPACK_IMPORTED_MODULE_2__.NotificationType.INFORMATION;
        this.title = '';
        this.content = '';
        this.logger = logger.scopeTo('Notification');
    }
    attaching() {
        this.logger.trace('Attaching', this.duration);
        if (!this.duration) {
            this.duration = 5000;
        }
    }
    attached() {
        this.logger.trace('Attached');
        this.openWithTransition();
        //@ts-ignore
        this.closeTimer = this.platform.setTimeout(() => {
            this.logger.trace('Auto close');
            this.closeWithTransition();
        }, this.duration);
    }
    detaching() {
        this.logger.trace('Detaching');
        if (this.wrapper.classList.contains('opened')) {
            return this.closeWithTransition()
                .then((value) => {
                return Promise.resolve();
            });
        }
        else {
            return Promise.resolve();
        }
    }
    onClose(evt) {
        evt.preventDefault();
        this.closeWithTransition();
    }
    closeWithTransition() {
        if (this.closeTimer) {
            this.platform.clearTimeout(this.closeTimer);
        }
        return (0,_helpers_transition__WEBPACK_IMPORTED_MODULE_3__.transitionWithPromise)({
            element: this.wrapper,
            afterDisplayStyle: 'none',
            startingCallback: () => {
                this.ea.publish(Notification_1.channel, {
                    status: _interfaces_notification__WEBPACK_IMPORTED_MODULE_2__.NotificationStatus.CLOSING,
                    index: this.index
                });
            },
            endingCallback: () => {
                this.ea.publish(Notification_1.channel, {
                    status: _interfaces_notification__WEBPACK_IMPORTED_MODULE_2__.NotificationStatus.CLOSED,
                    index: this.index
                });
            }
        }, [
            { element: this.wrapper, from: ['opened'], to: ['closed'], transition: ['closing'] }
        ]);
    }
    openWithTransition() {
        return (0,_helpers_transition__WEBPACK_IMPORTED_MODULE_3__.transitionWithPromise)({
            element: this.wrapper,
            beforeDisplayStyle: 'inherit',
            startingCallback: () => {
                this.ea.publish(Notification_1.channel, {
                    status: _interfaces_notification__WEBPACK_IMPORTED_MODULE_2__.NotificationStatus.OPENING,
                    index: this.index
                });
            },
            endingCallback: () => {
                this.ea.publish(Notification_1.channel, {
                    status: _interfaces_notification__WEBPACK_IMPORTED_MODULE_2__.NotificationStatus.OPENED,
                    index: this.index
                });
            }
        }, [
            { element: this.wrapper, from: ['closed'], to: ['opened'], transition: ['opening'] }
        ]);
    }
};
Notification.channel = 'Notification';
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.bindable)(),
    __metadata("design:type", String)
], Notification.prototype, "type", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.bindable)(),
    __metadata("design:type", String)
], Notification.prototype, "title", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.bindable)(),
    __metadata("design:type", String)
], Notification.prototype, "content", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.bindable)(),
    __metadata("design:type", Number)
], Notification.prototype, "index", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.bindable)(),
    __metadata("design:type", Number)
], Notification.prototype, "duration", void 0);
Notification = Notification_1 = __decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.customElement)(Object.assign(Object.assign({}, _notification_html__WEBPACK_IMPORTED_MODULE_0__), { name: 'blackcube-notification' })),
    __param(0, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__.ILogger),
    __param(1, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__.IEventAggregator),
    __param(2, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.IPlatform),
    __param(3, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.INode),
    __metadata("design:paramtypes", [Object, Object, Object, HTMLElement])
], Notification);



/***/ }),

/***/ "./app/components/overlay.ts":
/*!***********************************!*\
  !*** ./app/components/overlay.ts ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Overlay": () => (/* binding */ Overlay)
/* harmony export */ });
/* harmony import */ var _overlay_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./overlay.html */ "./app/components/overlay.html");
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! aurelia */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");
/* harmony import */ var _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @aurelia/kernel */ "../../../../node_modules/@aurelia/kernel/dist/esm/index.js");
/* harmony import */ var _services_http_service__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../services/http-service */ "./app/services/http-service.ts");
/* harmony import */ var _interfaces_overlay__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../interfaces/overlay */ "./app/interfaces/overlay.ts");
/* harmony import */ var _helpers_transition__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../helpers/transition */ "./app/helpers/transition.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (undefined && undefined.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};
var Overlay_1;







let Overlay = Overlay_1 = 
// @templateCompilerHooks()
class Overlay {
    constructor(logger, ea, platform, aurelia, httpService, element) {
        this.logger = logger;
        this.ea = ea;
        this.platform = platform;
        this.aurelia = aurelia;
        this.httpService = httpService;
        this.element = element;
        this.title = '';
        this.abstract = '';
        this.cancelTitle = '';
        this.actionTitle = '';
        this.isOpen = false;
        this.onOverlayEvent = (evt) => {
            if (evt.type === _interfaces_overlay__WEBPACK_IMPORTED_MODULE_3__.OverlayEventType.OPEN) {
                this.closeWithTransition()
                    .then((status) => {
                    var _a, _b, _c, _d;
                    //@ts-ignore
                    this.title = evt.overlay.title;
                    //@ts-ignore
                    this.abstract = evt.overlay.abstract;
                    this.cancel = (_a = evt.overlay) === null || _a === void 0 ? void 0 : _a.cancel;
                    this.action = (_b = evt.overlay) === null || _b === void 0 ? void 0 : _b.action;
                    this.cancelTitle = ((_c = evt.overlay) === null || _c === void 0 ? void 0 : _c.cancelTitle) || 'Cancel';
                    this.actionTitle = ((_d = evt.overlay) === null || _d === void 0 ? void 0 : _d.actionTitle) || 'Action';
                    //@ts-ignore
                    return this.httpService.getHtmlContent(evt.overlay.url);
                })
                    .then((html) => {
                    this.htmlData = html;
                    return new Promise((resolve) => {
                        this.platform.setTimeout(() => {
                            // make sure everything is correct and html is injected
                            resolve(true);
                        }, 40);
                    });
                })
                    .then((result) => {
                    // const au = new Aurelia();
                    // this.ctl = this.aurelia.enhance({host: this.outerElement, component: Enhance});
                    return this.openWithTransition();
                });
            }
            else if (evt.type === _interfaces_overlay__WEBPACK_IMPORTED_MODULE_3__.OverlayEventType.CLOSE) {
                this.closeWithTransition();
            }
        };
        this.onDelegatedEvent = (evt) => {
            var _a, _b, _c;
            // data-ajaxify-source=""
            const triggerElement = (_a = evt.target) === null || _a === void 0 ? void 0 : _a.closest('[data-overlay-action]');
            const submitEvt = evt;
            if (evt.type === 'click' && triggerElement && this.panel.contains(triggerElement)) {
                // c'est un click à monitorer
                if (triggerElement.dataset.overlayAction && triggerElement.dataset.overlayAction === 'close') {
                    evt.stopPropagation();
                    evt.preventDefault();
                    this.onClickClose(evt);
                    this.logger.warn('delegated ' + evt.type + ' done', evt.target, evt.type);
                }
                if (triggerElement.dataset.overlayAction && triggerElement.dataset.overlayAction === 'submit') {
                    evt.stopPropagation();
                    evt.preventDefault();
                    const elementForm = (_b = evt.target) === null || _b === void 0 ? void 0 : _b.closest('form');
                    if (elementForm) {
                        const body = new FormData(elementForm);
                        if (triggerElement instanceof HTMLButtonElement && triggerElement.hasAttribute('name') && triggerElement.hasAttribute('value')) {
                            body.append(triggerElement.name, triggerElement.value);
                        }
                        this.httpService.fetch(elementForm.action, { method: elementForm.method, body })
                            .then((data) => {
                            const url = data.headers.get('X-Redirect');
                            if (url) {
                                window.location.href = url;
                                throw new Error('Should redirect');
                            }
                            return data.text();
                        }).then((html) => {
                            this.htmlData = html;
                        });
                    }
                }
            }
            else if (evt.type === 'submit') {
                const elementForm = (_c = evt.target) === null || _c === void 0 ? void 0 : _c.closest('form');
                submitEvt.preventDefault();
                if (elementForm) {
                    // c'est un submit
                    const formData = new FormData(elementForm);
                    const submitter = submitEvt.submitter;
                    if (submitter.hasAttribute('name') && submitter.hasAttribute('value')) {
                        //@ts-ignore
                        formData.append(submitter.name, submitter.value);
                    }
                    this.httpService.runFormRequest(elementForm.action, formData, elementForm.method)
                        .then((html) => {
                        this.htmlData = html;
                    });
                    this.logger.warn('delegated ' + submitEvt.type + ' done');
                }
            }
        };
        this.onClickClose = (evt) => {
            if (this.cancel) {
                this.cancel();
            }
            this.closeWithTransition();
        };
        this.logger = logger.scopeTo('Overlay');
    }
    attaching() {
        this.logger.trace('Attaching');
        this.subscriber = this.ea.subscribe(Overlay_1.channel, this.onOverlayEvent);
    }
    attached() {
        this.element.style.display = 'none';
        this.logger.trace('Attached');
        this.panel.addEventListener('submit', this.onDelegatedEvent); //, {capture: true});
        this.panel.addEventListener('click', this.onDelegatedEvent); //, {capture: true});
    }
    detaching() {
        this.logger.trace('Detaching');
        this.panel.removeEventListener('click', this.onDelegatedEvent);
        this.panel.removeEventListener('submit', this.onDelegatedEvent);
    }
    dispose() {
        this.subscriber.dispose();
    }
    openWithTransition() {
        if (this.isOpen === false) {
            this.isOpen = true;
            return (0,_helpers_transition__WEBPACK_IMPORTED_MODULE_4__.transitionWithPromise)({
                element: this.element,
                beforeDisplayStyle: 'inherit',
                startingCallback: () => {
                    this.ea.publish(Overlay_1.channel, {
                        status: _interfaces_overlay__WEBPACK_IMPORTED_MODULE_3__.OverlayStatus.OPENING
                    });
                    //this.attachButtons();
                },
                endingCallback: () => {
                    this.ea.publish(Overlay_1.channel, {
                        status: _interfaces_overlay__WEBPACK_IMPORTED_MODULE_3__.OverlayStatus.OPENED
                    });
                }
            }, [
                { element: this.overlay, from: ['closed'], to: ['opened'], transition: ['opening'] },
                { element: this.panel, from: ['closed'], to: ['opened'], transition: ['opening'] }
            ]);
        }
        else {
            return Promise.resolve(true);
        }
    }
    closeWithTransition() {
        if (this.isOpen === true) {
            this.isOpen = false;
            //this.detachButtons();
            return (0,_helpers_transition__WEBPACK_IMPORTED_MODULE_4__.transitionWithPromise)({
                element: this.element,
                afterDisplayStyle: 'none',
                startingCallback: () => {
                    this.ea.publish(Overlay_1.channel, {
                        status: _interfaces_overlay__WEBPACK_IMPORTED_MODULE_3__.OverlayStatus.CLOSING
                    });
                },
                endingCallback: () => {
                    this.htmlData = '';
                    this.ea.publish(Overlay_1.channel, {
                        status: _interfaces_overlay__WEBPACK_IMPORTED_MODULE_3__.OverlayStatus.CLOSED
                    });
                }
            }, [
                { element: this.overlay, from: ['opened'], to: ['closed'], transition: ['closing'] },
                { element: this.panel, from: ['opened'], to: ['closed'], transition: ['closing'] }
            ]);
        }
        else {
            return Promise.resolve(true);
        }
    }
};
Overlay.channel = 'Overlay';
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.bindable)(),
    __metadata("design:type", String)
], Overlay.prototype, "title", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.bindable)(),
    __metadata("design:type", String)
], Overlay.prototype, "abstract", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.bindable)(),
    __metadata("design:type", String)
], Overlay.prototype, "cancelTitle", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.bindable)(),
    __metadata("design:type", String)
], Overlay.prototype, "actionTitle", void 0);
Overlay = Overlay_1 = __decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.customElement)(Object.assign(Object.assign({}, _overlay_html__WEBPACK_IMPORTED_MODULE_0__), { name: 'blackcube-overlay' }))
    // @templateCompilerHooks()
    ,
    __param(0, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__.ILogger),
    __param(1, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__.IEventAggregator),
    __param(2, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.IPlatform),
    __param(3, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.IAurelia),
    __param(5, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_5__.INode),
    __metadata("design:paramtypes", [Object, Object, Object, Object, _services_http_service__WEBPACK_IMPORTED_MODULE_2__.HttpService,
        HTMLElement])
], Overlay);



/***/ }),

/***/ "./app/components/permissions.ts":
/*!***************************************!*\
  !*** ./app/components/permissions.ts ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Permissions": () => (/* binding */ Permissions)
/* harmony export */ });
/* harmony import */ var _permissions_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./permissions.html */ "./app/components/permissions.html");
/* harmony import */ var _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @aurelia/kernel */ "../../../../node_modules/@aurelia/kernel/dist/esm/index.js");
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");
/* harmony import */ var _services_http_service__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../services/http-service */ "./app/services/http-service.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (undefined && undefined.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};





let Permissions = class Permissions {
    constructor(logger, platform, httpService, element) {
        this.logger = logger;
        this.platform = platform;
        this.httpService = httpService;
        this.element = element;
        this.view = '';
        this.onDelegateChange = (evt) => {
            if (evt.target) {
                //TODO: make better delegate
                //@ts-ignore
                let currentCheckbox = evt.target.closest('input[type=checkbox]');
                if (currentCheckbox && this.element.contains(currentCheckbox)) {
                    evt.stopPropagation();
                    evt.preventDefault();
                    this.logger.debug('delegateClick');
                    const body = new FormData();
                    body.append(this.csrf.name, this.csrf.value);
                    if (currentCheckbox.dataset.rbacType) {
                        //@ts-ignore
                        body.append('type', currentCheckbox.dataset.rbacType);
                    }
                    if (currentCheckbox.dataset.rbacName) {
                        //@ts-ignore
                        body.append('name', currentCheckbox.dataset.rbacName);
                    }
                    body.append('mode', currentCheckbox.checked ? 'add' : 'remove');
                    // const body = new FormData(this.form);
                    const method = 'post';
                    this.httpService.fetch(this.url, { body, method })
                        .then(response => {
                        return response.text();
                    })
                        .then((html) => {
                        this.view = html;
                    });
                }
            }
        };
        this.logger = logger.scopeTo('Permissions');
    }
    attached() {
        this.logger.debug('Attached');
        this.logger.debug(this.url);
        this.form = this.element.closest('form');
        let csrfField = this.form.querySelector('input[name=_csrf]');
        this.csrf = {
            name: csrfField.name,
            value: csrfField.value
        };
        this.logger.debug(this.form);
        this.element.addEventListener('change', this.onDelegateChange);
        const body = new FormData();
        body.append(this.csrf.name, this.csrf.value);
        // const body = new FormData(this.form);
        const method = 'post';
        this.httpService.fetch(this.url, { body, method })
            .then(response => {
            return response.text();
        })
            .then((html) => {
            this.view = html;
        });
    }
    detaching() {
        this.logger.debug('Detached');
        this.element.removeEventListener('change', this.onDelegateChange);
    }
};
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.bindable)(),
    __metadata("design:type", String)
], Permissions.prototype, "url", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.bindable)(),
    __metadata("design:type", String)
], Permissions.prototype, "view", void 0);
Permissions = __decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.customElement)(Object.assign(Object.assign({}, _permissions_html__WEBPACK_IMPORTED_MODULE_0__), { name: 'blackcube-permissions' })),
    __param(0, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__.ILogger),
    __param(1, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.IPlatform),
    __param(3, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.INode),
    __metadata("design:paramtypes", [Object, Object, _services_http_service__WEBPACK_IMPORTED_MODULE_2__.HttpService,
        HTMLElement])
], Permissions);



/***/ }),

/***/ "./app/components/profile.ts":
/*!***********************************!*\
  !*** ./app/components/profile.ts ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Profile": () => (/* binding */ Profile)
/* harmony export */ });
/* harmony import */ var _profile_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./profile.html */ "./app/components/profile.html");
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! aurelia */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime/dist/esm/index.js");
/* harmony import */ var _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @aurelia/kernel */ "../../../../node_modules/@aurelia/kernel/dist/esm/index.js");
/* harmony import */ var _interfaces_profile__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../interfaces/profile */ "./app/interfaces/profile.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (undefined && undefined.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};
var Profile_1;





let Profile = Profile_1 = class Profile {
    constructor(logger, ea, platform, element) {
        this.logger = logger;
        this.ea = ea;
        this.platform = platform;
        this.element = element;
        this.items = [];
        this.hasListener = false;
        this.onTransitionMenuEnded = (evt) => {
            if (this.menu.classList.contains('closing')) {
                this.menu.classList.remove('closing', 'opened');
                this.menu.style.display = 'none';
                this.ea.publish(Profile_1.channel, { status: _interfaces_profile__WEBPACK_IMPORTED_MODULE_2__.ProfileStatus.CLOSED });
            }
            else if (this.menu.classList.contains('opening')) {
                this.menu.classList.remove('opening', 'closed');
                this.ea.publish(Profile_1.channel, { status: _interfaces_profile__WEBPACK_IMPORTED_MODULE_2__.ProfileStatus.OPENED });
            }
        };
        this.logger = logger.scopeTo('Profile');
    }
    attaching() {
        this.logger.trace('Attaching');
    }
    attached() {
        this.logger.trace('Attached');
        if (this.items.length > 0) {
            this.hasListener = true;
            this.menu.style.display = 'none';
            this.menu.addEventListener('transitionend', this.onTransitionMenuEnded);
        }
    }
    detaching() {
        this.logger.trace('Detaching');
        if (this.hasListener === true) {
            this.menu.removeEventListener('transitionend', this.onTransitionMenuEnded);
        }
    }
    onToggle(evt) {
        if (this.items.length > 0) {
            if (this.menu.classList.contains('opened')) {
                this.closeMenu(evt);
            }
            else if (this.menu.classList.contains('closed')) {
                this.openMenu(evt);
            }
        }
    }
    onClickItem(evt, index) {
        this.closeMenu(evt);
    }
    openMenu(evt) {
        this.ea.publish(Profile_1.channel, { status: _interfaces_profile__WEBPACK_IMPORTED_MODULE_2__.ProfileStatus.OPENING });
        this.menu.style.display = 'inherit';
        this.platform.setTimeout(() => {
            this.menu.classList.remove('closed');
            this.menu.classList.add('opening', 'opened');
        }, 0);
    }
    closeMenu(evt) {
        this.ea.publish(Profile_1.channel, { status: _interfaces_profile__WEBPACK_IMPORTED_MODULE_2__.ProfileStatus.CLOSING });
        this.menu.classList.remove('opened');
        this.menu.classList.add('closing', 'closed');
    }
    handleTransitionMenu(newValue, oldValue) {
        this.logger.debug('onChangeItems', newValue, oldValue);
        if (newValue > 0 && oldValue === 0) {
            this.platform.setTimeout(() => {
                this.menu.addEventListener('transitionend', this.onTransitionMenuEnded);
            });
            this.hasListener = true;
        }
        else if (newValue === 0 && oldValue > 0) {
            this.menu.removeEventListener('transitionend', this.onTransitionMenuEnded);
            this.hasListener = false;
        }
    }
};
Profile.channel = 'Profile';
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.bindable)({ mode: _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.BindingMode.toView }),
    __metadata("design:type", String)
], Profile.prototype, "avatar", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.bindable)({ mode: _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.BindingMode.toView }),
    __metadata("design:type", String)
], Profile.prototype, "initials", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.bindable)({ mode: _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.BindingMode.toView }),
    __metadata("design:type", Array)
], Profile.prototype, "items", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.watch)((profile) => profile.items.length),
    __metadata("design:type", Function),
    __metadata("design:paramtypes", [Object, Object]),
    __metadata("design:returntype", void 0)
], Profile.prototype, "handleTransitionMenu", null);
Profile = Profile_1 = __decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.customElement)(Object.assign(Object.assign({}, _profile_html__WEBPACK_IMPORTED_MODULE_0__), { name: 'blackcube-profile' })),
    __param(0, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__.ILogger),
    __param(1, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__.IEventAggregator),
    __param(2, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.IPlatform),
    __param(3, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.INode),
    __metadata("design:paramtypes", [Object, Object, Object, HTMLElement])
], Profile);



/***/ }),

/***/ "./app/components/quill-editor.ts":
/*!****************************************!*\
  !*** ./app/components/quill-editor.ts ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "QuillEditor": () => (/* binding */ QuillEditor)
/* harmony export */ });
/* harmony import */ var _quill_editor_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./quill-editor.html */ "./app/components/quill-editor.html");
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");
/* harmony import */ var _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @aurelia/kernel */ "../../../../node_modules/@aurelia/kernel/dist/esm/index.js");
/* harmony import */ var _services_http_service__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../services/http-service */ "./app/services/http-service.ts");
/* harmony import */ var quill__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! quill */ "../../../../node_modules/quill/dist/quill.js");
/* harmony import */ var quill__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(quill__WEBPACK_IMPORTED_MODULE_3__);
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (undefined && undefined.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};





const Link = quill__WEBPACK_IMPORTED_MODULE_3___default()["import"]('formats/link');
class BlackcubeLink extends Link {
    static create(value) {
        let node = super.create(value);
        value = this.sanitize(value);
        node.setAttribute('href', value);
        if (value.startsWith("https://") || value.startsWith("http://") || value.startsWith("://")) {
            // do nothing
        }
        else {
            node.removeAttribute('target');
        }
        return node;
    }
}
quill__WEBPACK_IMPORTED_MODULE_3___default().register(BlackcubeLink, true);
let QuillEditor = class QuillEditor {
    constructor(logger, ea, httpService, element) {
        this.logger = logger;
        this.ea = ea;
        this.httpService = httpService;
        this.element = element;
        this.content = '';
        this.options = {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'bullet' }],
                    ['link']
                ]
            },
            formats: ['bold', 'italic', 'link', 'underline', 'list']
        };
        this.onTextChange = () => {
            var _a, _b;
            // @ts-ignore
            this.hiddenField.value = (_a = this.editorElement.querySelector('.ql-editor')) === null || _a === void 0 ? void 0 : _a.innerHTML;
            this.logger.trace((_b = this.editorElement.querySelector('.ql-editor')) === null || _b === void 0 ? void 0 : _b.innerHTML);
        };
        this.logger = logger.scopeTo('QuillEditor');
    }
    attaching() {
        this.logger.trace('Attaching');
    }
    attached() {
        if (this.fieldId) {
            this.hiddenField.id = this.fieldId;
        }
        if (this.fieldName) {
            this.hiddenField.name = this.fieldName;
        }
        this.hiddenField.value = this.content;
        this.editorElement.innerHTML = this.content;
        this.options.theme = 'snow';
        this.quill = new (quill__WEBPACK_IMPORTED_MODULE_3___default())(this.editorElement, this.options);
        this.quill.on('text-change', this.onTextChange);
        this.logger.trace('Attached');
    }
    detaching() {
        this.quill.off('text-change', this.onTextChange);
        this.logger.trace('Detaching');
    }
};
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.bindable)(),
    __metadata("design:type", String)
], QuillEditor.prototype, "fieldId", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.bindable)(),
    __metadata("design:type", String)
], QuillEditor.prototype, "fieldName", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.bindable)(),
    __metadata("design:type", String)
], QuillEditor.prototype, "content", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.bindable)(),
    __metadata("design:type", Object)
], QuillEditor.prototype, "options", void 0);
QuillEditor = __decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.customElement)(Object.assign(Object.assign({}, _quill_editor_html__WEBPACK_IMPORTED_MODULE_0__), { name: 'blackcube-quill-editor' })),
    __param(0, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__.ILogger),
    __param(1, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__.IEventAggregator),
    __param(3, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.INode),
    __metadata("design:paramtypes", [Object, Object, _services_http_service__WEBPACK_IMPORTED_MODULE_2__.HttpService,
        HTMLElement])
], QuillEditor);



/***/ }),

/***/ "./app/components/schema-editor.ts":
/*!*****************************************!*\
  !*** ./app/components/schema-editor.ts ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "SchemaEditor": () => (/* binding */ SchemaEditor)
/* harmony export */ });
/* harmony import */ var _schema_editor_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./schema-editor.html */ "./app/components/schema-editor.html");
/* harmony import */ var _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @aurelia/kernel */ "../../../../node_modules/@aurelia/kernel/dist/esm/index.js");
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");
/* harmony import */ var jsoneditor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! jsoneditor */ "../../../../node_modules/jsoneditor/dist/jsoneditor.min.js");
/* harmony import */ var jsoneditor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(jsoneditor__WEBPACK_IMPORTED_MODULE_2__);
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (undefined && undefined.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};





let SchemaEditor = class SchemaEditor {
    constructor(logger, platform, element) {
        this.logger = logger;
        this.platform = platform;
        this.element = element;
        this.logger = logger.scopeTo('SchemaEditor');
    }
    attached() {
        this.logger.debug('Attached');
        if (this.fieldId) {
            this.hiddenField.id = this.fieldId;
        }
        if (this.fieldName) {
            this.hiddenField.name = this.fieldName;
        }
        if (this.schema) {
            this.hiddenField.value = this.schema;
        }
        this.buildEditor();
    }
    buildEditor() {
        // @ts-ignore
        let config = {
            mode: "tree",
            modes: ["tree", "text"],
            search: false,
            navigationBar: false,
            statusBar: true,
            mainMenuBar: true,
            enableSort: false,
            enableTransform: false,
            language: "en",
            templates: [
                {
                    text: 'text',
                    title: 'Insert Text property',
                    className: 'jsoneditor-type-object',
                    field: 'text',
                    value: {
                        type: 'string',
                        title: 'Text',
                        minLength: 6,
                        description: 'Field description'
                    }
                },
                {
                    text: 'Textarea',
                    title: 'Insert Textarea property',
                    className: 'jsoneditor-type-object',
                    field: "textarea",
                    value: {
                        type: 'string',
                        format: 'textarea',
                        description: 'Field description'
                    }
                },
                {
                    text: 'Wysiwyg',
                    title: 'Insert Wysiwyg property',
                    className: 'jsoneditor-type-object',
                    field: "wysiwyg",
                    value: {
                        type: 'string',
                        format: 'wysiwyg',
                        options: {
                            theme: "snow",
                            modules: {
                                toolbar: [
                                    ["bold", "italic", "underline"],
                                    [
                                        {
                                            list: "bullet"
                                        }
                                    ],
                                    ["link"]
                                ]
                            },
                            formats: ["bold", "italic", "link", "underline", "list"]
                        },
                        description: 'Wysiwyg Editor'
                    }
                },
                {
                    text: 'Email',
                    title: 'Insert Email property',
                    className: 'jsoneditor-type-object',
                    field: 'email',
                    value: {
                        type: 'string',
                        title: 'E-mail',
                        format: 'email',
                        minLength: 6,
                        description: 'Field description'
                    }
                },
                {
                    text: 'Regexp',
                    title: 'Insert Regexp property',
                    className: 'jsoneditor-type-object',
                    field: "regexp",
                    value: {
                        type: 'string',
                        pattern: '^[a-z0-9]+$',
                        minLength: 6,
                        title: "Regep",
                        description: 'Field description'
                    }
                },
                {
                    text: 'Images',
                    title: 'Insert Image property',
                    className: 'jsoneditor-type-object',
                    field: "image",
                    value: {
                        type: 'string',
                        format: 'files',
                        fileType: 'png,jpg',
                        imageWidth: 600,
                        imageHeight: 200,
                        title: "images",
                        description: 'Images size should be 600x200'
                    }
                },
                {
                    text: 'File',
                    title: 'Insert Image property',
                    className: 'jsoneditor-type-object',
                    field: "file",
                    value: {
                        type: 'string',
                        format: 'file',
                        fileType: 'pdf',
                        title: "file",
                        description: 'Field description'
                    }
                },
                {
                    text: 'Files',
                    title: 'Insert Image property',
                    className: 'jsoneditor-type-object',
                    field: "files",
                    value: {
                        type: 'string',
                        format: 'files',
                        fileType: 'pdf',
                        title: "files",
                        description: 'Field description'
                    }
                }
            ]
        };
        if (this.language) {
            config.language = this.language;
        }
        config.onChangeJSON = (jsonData) => {
            // @ts-ignore
            this.hiddenField.value = JSON.stringify(jsonData, null, 4);
        };
        config.onChangeText = (jsonString) => {
            // @ts-ignore
            this.hiddenField.value = jsonString;
        };
        this.jsonSchema = new (jsoneditor__WEBPACK_IMPORTED_MODULE_2___default())(this.editorElement, config);
        this.jsonSchema.setText(this.schema);
        this.jsonSchema.expandAll();
    }
};
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.bindable)(),
    __metadata("design:type", String)
], SchemaEditor.prototype, "fieldId", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.bindable)(),
    __metadata("design:type", String)
], SchemaEditor.prototype, "fieldName", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.bindable)(),
    __metadata("design:type", String)
], SchemaEditor.prototype, "schema", void 0);
__decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.bindable)(),
    __metadata("design:type", String)
], SchemaEditor.prototype, "language", void 0);
SchemaEditor = __decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.customElement)(Object.assign(Object.assign({}, _schema_editor_html__WEBPACK_IMPORTED_MODULE_0__), { name: 'blackcube-schema-editor' })),
    __param(0, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__.ILogger),
    __param(1, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.IPlatform),
    __param(2, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_3__.INode),
    __metadata("design:paramtypes", [Object, Object, HTMLElement])
], SchemaEditor);



/***/ }),

/***/ "./app/components/test.ts":
/*!********************************!*\
  !*** ./app/components/test.ts ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Test": () => (/* binding */ Test)
/* harmony export */ });
/* harmony import */ var _test_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./test.html */ "./app/components/test.html");
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");
/* harmony import */ var _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @aurelia/kernel */ "../../../../node_modules/@aurelia/kernel/dist/esm/index.js");
/* harmony import */ var _interfaces_alert__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../interfaces/alert */ "./app/interfaces/alert.ts");
/* harmony import */ var _alert__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./alert */ "./app/components/alert.ts");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (undefined && undefined.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};





let Test = class Test {
    constructor(logger, ea) {
        this.logger = logger;
        this.ea = ea;
        this.logger = logger.scopeTo('Profile');
    }
    attaching() {
        this.logger.trace('Attaching');
    }
    attached() {
        this.logger.trace('Attached');
    }
    bound() {
        this.logger.trace('Bound');
    }
    detaching() {
        this.logger.trace('Detaching');
    }
    onClick(evt) {
        evt.preventDefault();
        this.logger.warn('Click');
        this.ea.publish(_alert__WEBPACK_IMPORTED_MODULE_3__.Alert.channel, {
            type: _interfaces_alert__WEBPACK_IMPORTED_MODULE_2__.AlertEventType.OPEN,
            alert: {
                type: _interfaces_alert__WEBPACK_IMPORTED_MODULE_2__.AlertType.QUESTION,
                title: 'Titre Alerte',
                content: 'Contenu Alerte',
                action: () => {
                    this.logger.warn('Closing with action');
                },
                cancel: () => {
                    this.logger.warn('Closing with cancel');
                }
            }
        });
    }
};
Test = __decorate([
    (0,_aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_4__.customElement)(Object.assign(Object.assign({}, _test_html__WEBPACK_IMPORTED_MODULE_0__), { name: 'blackcube-test' })),
    __param(0, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__.ILogger),
    __param(1, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_1__.IEventAggregator),
    __metadata("design:paramtypes", [Object, Object])
], Test);



/***/ }),

/***/ "./app/enhance.ts":
/*!************************!*\
  !*** ./app/enhance.ts ***!
  \************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Enhance": () => (/* binding */ Enhance)
/* harmony export */ });
/* harmony import */ var _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/kernel */ "../../../../node_modules/@aurelia/kernel/dist/esm/index.js");
/* harmony import */ var _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @aurelia/runtime-html */ "../../../../node_modules/@aurelia/runtime-html/dist/esm/index.js");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (undefined && undefined.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};


let Enhance = class Enhance {
    constructor(logger, ea, element) {
        this.logger = logger;
        this.ea = ea;
        this.element = element;
        this.logger = logger.scopeTo('Enhance');
    }
    attaching() {
        this.logger.trace('Attaching');
    }
};
Enhance = __decorate([
    __param(0, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__.ILogger),
    __param(1, _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__.IEventAggregator),
    __param(2, _aurelia_runtime_html__WEBPACK_IMPORTED_MODULE_1__.INode),
    __metadata("design:paramtypes", [Object, Object, HTMLElement])
], Enhance);



/***/ }),

/***/ "./app/helpers/transition.ts":
/*!***********************************!*\
  !*** ./app/helpers/transition.ts ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "transitionWithPromise": () => (/* binding */ transitionWithPromise)
/* harmony export */ });
function transitionWithPromise(outer, transitions) {
    // XXX beforeStart XXX send event this.ea.publish(Alert.channel, {status: AlertStatus.OPENING})
    // stack everything to avoid glitches
    const animationPromise = new Promise((resolve) => {
        if (outer.startingCallback) {
            outer.startingCallback();
        }
        if (outer.beforeDisplayStyle) {
            outer.element.style.display = outer.beforeDisplayStyle;
        }
        setTimeout(() => {
            resolve(true);
        }, 10);
    });
    return animationPromise
        .then((status) => {
        const animationPromises = [Promise.resolve(true)];
        transitions.forEach((transition) => {
            const transitionPromise = new Promise((resolve) => {
                const endingTransition = (evt) => {
                    // const firstTransitionClass = transition.transition[0];
                    // if (transition.element.classList.contains(firstTransitionClass)) {
                    transition.element.removeEventListener('transitionend', endingTransition);
                    transition.transition.forEach((transitionClass) => {
                        transition.element.classList.remove(transitionClass);
                    });
                    resolve(true);
                    // }
                };
                transition.element.addEventListener('transitionend', endingTransition);
                transition.from.forEach((transitionClass) => {
                    transition.element.classList.remove(transitionClass);
                });
                transition.to.forEach((transitionClass) => {
                    transition.element.classList.add(transitionClass);
                });
                transition.transition.forEach((transitionClass) => {
                    transition.element.classList.add(transitionClass);
                });
            });
            animationPromises.push(transitionPromise);
        });
        return Promise.all(animationPromises);
        // from 'closed'
        // to 'opened'
        // transition 'opening'
    })
        .then((animationStatuses) => {
        const status = animationStatuses.reduce((accumulator, status) => {
            return accumulator && status;
        }, true);
        return new Promise(resolve => {
            setTimeout(() => {
                resolve(status);
            });
        });
    })
        .then((status) => {
        const finalPromises = [];
        finalPromises.push(Promise.resolve(status));
        transitions.forEach((transition) => {
            transition.transition.forEach((transitionClass) => {
                // clean up transition stuff
                finalPromises.push(new Promise((resolve) => {
                    transition.element.classList.remove(transitionClass);
                    resolve(true);
                }));
            });
        });
        return Promise.all(finalPromises);
    })
        .then((status) => {
        if (outer.afterDisplayStyle) {
            outer.element.style.display = outer.afterDisplayStyle;
        }
        if (outer.endingCallback) {
            outer.endingCallback();
        }
        return new Promise((resolve) => {
            setTimeout(() => {
                resolve(true);
            }, 10);
        });
        // return status;
    });
}


/***/ }),

/***/ "./app/interfaces/alert.ts":
/*!*********************************!*\
  !*** ./app/interfaces/alert.ts ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "AlertEventType": () => (/* binding */ AlertEventType),
/* harmony export */   "AlertStatus": () => (/* binding */ AlertStatus),
/* harmony export */   "AlertType": () => (/* binding */ AlertType)
/* harmony export */ });
var AlertStatus;
(function (AlertStatus) {
    AlertStatus[AlertStatus["OPENING"] = 0] = "OPENING";
    AlertStatus[AlertStatus["OPENED"] = 1] = "OPENED";
    AlertStatus[AlertStatus["CLOSING"] = 2] = "CLOSING";
    AlertStatus[AlertStatus["CLOSED"] = 3] = "CLOSED";
    AlertStatus[AlertStatus["REMOVED"] = 4] = "REMOVED";
})(AlertStatus || (AlertStatus = {}));
var AlertType;
(function (AlertType) {
    AlertType["CHECK"] = "check";
    AlertType["EXCLAMATION"] = "exclamation";
    AlertType["QUESTION"] = "question";
})(AlertType || (AlertType = {}));
var AlertEventType;
(function (AlertEventType) {
    AlertEventType[AlertEventType["OPEN"] = 0] = "OPEN";
    AlertEventType[AlertEventType["CLOSE"] = 1] = "CLOSE";
})(AlertEventType || (AlertEventType = {}));


/***/ }),

/***/ "./app/interfaces/broadcast.ts":
/*!*************************************!*\
  !*** ./app/interfaces/broadcast.ts ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Broadcast": () => (/* binding */ Broadcast),
/* harmony export */   "BroadcastElementEventType": () => (/* binding */ BroadcastElementEventType)
/* harmony export */ });
var BroadcastElementEventType;
(function (BroadcastElementEventType) {
    BroadcastElementEventType["CREATE"] = "create";
    BroadcastElementEventType["UPDATE"] = "update";
    BroadcastElementEventType["DELETE"] = "delete";
    BroadcastElementEventType["ACTIVATE"] = "activate";
    BroadcastElementEventType["DEACTIVATE"] = "deactivate";
})(BroadcastElementEventType || (BroadcastElementEventType = {}));
class Broadcast {
}
Broadcast.channel = 'general';


/***/ }),

/***/ "./app/interfaces/menu.ts":
/*!********************************!*\
  !*** ./app/interfaces/menu.ts ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "MenuEventType": () => (/* binding */ MenuEventType),
/* harmony export */   "MenuStatus": () => (/* binding */ MenuStatus)
/* harmony export */ });
var MenuEventType;
(function (MenuEventType) {
    MenuEventType[MenuEventType["OPEN"] = 0] = "OPEN";
    MenuEventType[MenuEventType["CLOSE"] = 1] = "CLOSE";
})(MenuEventType || (MenuEventType = {}));
var MenuStatus;
(function (MenuStatus) {
    MenuStatus[MenuStatus["OPENING"] = 0] = "OPENING";
    MenuStatus[MenuStatus["OPENED"] = 1] = "OPENED";
    MenuStatus[MenuStatus["CLOSING"] = 2] = "CLOSING";
    MenuStatus[MenuStatus["CLOSED"] = 3] = "CLOSED";
})(MenuStatus || (MenuStatus = {}));


/***/ }),

/***/ "./app/interfaces/notification.ts":
/*!****************************************!*\
  !*** ./app/interfaces/notification.ts ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "NotificationCenterEventType": () => (/* binding */ NotificationCenterEventType),
/* harmony export */   "NotificationStatus": () => (/* binding */ NotificationStatus),
/* harmony export */   "NotificationType": () => (/* binding */ NotificationType)
/* harmony export */ });
var NotificationStatus;
(function (NotificationStatus) {
    NotificationStatus[NotificationStatus["OPENING"] = 0] = "OPENING";
    NotificationStatus[NotificationStatus["OPENED"] = 1] = "OPENED";
    NotificationStatus[NotificationStatus["CLOSING"] = 2] = "CLOSING";
    NotificationStatus[NotificationStatus["CLOSED"] = 3] = "CLOSED";
    NotificationStatus[NotificationStatus["REMOVED"] = 4] = "REMOVED";
})(NotificationStatus || (NotificationStatus = {}));
var NotificationType;
(function (NotificationType) {
    NotificationType["CHECK"] = "check";
    NotificationType["EXCLAMATION"] = "exclamation";
    NotificationType["INFORMATION"] = "information";
})(NotificationType || (NotificationType = {}));
var NotificationCenterEventType;
(function (NotificationCenterEventType) {
    NotificationCenterEventType[NotificationCenterEventType["CREATE"] = 0] = "CREATE";
    NotificationCenterEventType[NotificationCenterEventType["REMOVE_ALL"] = 1] = "REMOVE_ALL";
})(NotificationCenterEventType || (NotificationCenterEventType = {}));


/***/ }),

/***/ "./app/interfaces/overlay.ts":
/*!***********************************!*\
  !*** ./app/interfaces/overlay.ts ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "OverlayEventType": () => (/* binding */ OverlayEventType),
/* harmony export */   "OverlayStatus": () => (/* binding */ OverlayStatus)
/* harmony export */ });
var OverlayStatus;
(function (OverlayStatus) {
    OverlayStatus[OverlayStatus["OPENING"] = 0] = "OPENING";
    OverlayStatus[OverlayStatus["OPENED"] = 1] = "OPENED";
    OverlayStatus[OverlayStatus["CLOSING"] = 2] = "CLOSING";
    OverlayStatus[OverlayStatus["CLOSED"] = 3] = "CLOSED";
    OverlayStatus[OverlayStatus["REMOVED"] = 4] = "REMOVED";
})(OverlayStatus || (OverlayStatus = {}));
var OverlayEventType;
(function (OverlayEventType) {
    OverlayEventType[OverlayEventType["OPEN"] = 0] = "OPEN";
    OverlayEventType[OverlayEventType["CLOSE"] = 1] = "CLOSE";
})(OverlayEventType || (OverlayEventType = {}));


/***/ }),

/***/ "./app/interfaces/profile.ts":
/*!***********************************!*\
  !*** ./app/interfaces/profile.ts ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ProfileStatus": () => (/* binding */ ProfileStatus)
/* harmony export */ });
var ProfileStatus;
(function (ProfileStatus) {
    ProfileStatus[ProfileStatus["OPENED"] = 0] = "OPENED";
    ProfileStatus[ProfileStatus["OPENING"] = 1] = "OPENING";
    ProfileStatus[ProfileStatus["CLOSED"] = 2] = "CLOSED";
    ProfileStatus[ProfileStatus["CLOSING"] = 3] = "CLOSING";
})(ProfileStatus || (ProfileStatus = {}));


/***/ }),

/***/ "./app/services/StorageService.ts":
/*!****************************************!*\
  !*** ./app/services/StorageService.ts ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "StorageService": () => (/* binding */ StorageService)
/* harmony export */ });
class StorageService {
    getElementOpened(elementType, elementSubData, elementId) {
        if (elementId !== '' && elementSubData !== '' && elementType !== '') {
            const storageStatus = localStorage.getItem('admin:element:' + elementType + '-' + elementId + ':' + elementSubData + ':opened');
            return storageStatus === '1';
        }
        return false;
    }
    setElementOpened(elementType, elementSubData, elementId) {
        if (elementId !== '' && elementSubData !== '' && elementType !== '') {
            localStorage.setItem('admin:element:' + elementType + '-' + elementId + ':' + elementSubData + ':opened', '1');
        }
    }
    setElementClosed(elementType, elementSubData, elementId) {
        if (elementId !== '' && elementSubData !== '' && elementType !== '') {
            localStorage.removeItem('admin:element:' + elementType + '-' + elementId + ':' + elementSubData + ':opened');
        }
    }
    getSectionOpened(elementType, elementId) {
        if (elementId !== '' && elementType !== '') {
            const storageStatus = localStorage.getItem('admin:section:' + elementType + '-' + elementId + ':opened');
            return storageStatus === '1';
        }
        return false;
    }
    setSectionOpened(elementType, elementId) {
        if (elementId !== '' && elementType !== '') {
            localStorage.setItem('admin:section:' + elementType + '-' + elementId + ':opened', '1');
        }
    }
    setSectionClosed(elementType, elementId) {
        if (elementId !== '' && elementType !== '') {
            localStorage.removeItem('admin:section:' + elementType + '-' + elementId + ':opened');
        }
    }
    getElementSlugOpened(elementId) {
        if (elementId !== '') {
            const storageStatus = localStorage.getItem('admin:element:' + elementId + ':slug:opened');
            return storageStatus === '1';
        }
        return false;
    }
    setElementSlugOpened(elementId) {
        if (elementId !== '') {
            localStorage.setItem('admin:element:' + elementId + ':slug:opened', '1');
        }
    }
    setElementSlugClosed(elementId) {
        if (elementId !== '') {
            localStorage.removeItem('admin:element:' + elementId + ':slug:opened');
        }
    }
}



/***/ }),

/***/ "./app/services/http-service.ts":
/*!**************************************!*\
  !*** ./app/services/http-service.ts ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "HttpService": () => (/* binding */ HttpService)
/* harmony export */ });
/* harmony import */ var _aurelia_fetch_client__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/fetch-client */ "../../../../node_modules/@aurelia/fetch-client/dist/esm/index.mjs");
var __decorate = (undefined && undefined.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (undefined && undefined.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (undefined && undefined.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};

let HttpService = class HttpService {
    constructor(httpClient) {
        this.httpClient = httpClient;
        this.httpClient.configure((config) => {
            config.withDefaults({
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'include'
            });
            return config;
        });
    }
    getHtmlContent(url) {
        const requestInit = {
            headers: {
                'Accept': 'text/html'
            }
        };
        return this.httpClient.get(url, requestInit)
            .then((response) => {
            return response.text();
        });
    }
    runFormRequest(url, body = null, method = 'post') {
        return this.httpClient.fetch(url, {
            method: method.toLocaleLowerCase(),
            body,
        })
            .then((response) => {
            return response.text();
        });
    }
    fetch(input, init) {
        return this.httpClient.fetch(input, init);
    }
    deleteRequest(url, csrf = '') {
        return this.httpClient.fetch(url, { method: 'delete', headers: { 'X-CSRF-Token': csrf } });
    }
};
HttpService = __decorate([
    __param(0, _aurelia_fetch_client__WEBPACK_IMPORTED_MODULE_0__.IHttpClient),
    __metadata("design:paramtypes", [Object])
], HttpService);



/***/ }),

/***/ "./startup.ts":
/*!********************!*\
  !*** ./startup.ts ***!
  \********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var aurelia__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! aurelia */ "../../../../node_modules/aurelia/dist/esm/index.mjs");
/* harmony import */ var _aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @aurelia/kernel */ "../../../../node_modules/@aurelia/kernel/dist/esm/index.js");
/* harmony import */ var _app_attributes_index__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./app/attributes/index */ "./app/attributes/index.ts");
/* harmony import */ var _app_components_index__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./app/components/index */ "./app/components/index.ts");
/* harmony import */ var _app_enhance__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./app/enhance */ "./app/enhance.ts");


if (window.webpackBaseUrl) {
    __webpack_require__.p = webpackBaseUrl;
}



const page = document.querySelector('body');
if (true) {
    aurelia__WEBPACK_IMPORTED_MODULE_4__["default"].register(_app_attributes_index__WEBPACK_IMPORTED_MODULE_1__)
        .register(_app_components_index__WEBPACK_IMPORTED_MODULE_2__)
        .register(_aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__.LoggerConfiguration.create({
        level: 0 /* trace */,
        colorOptions: 1,
        sinks: [_aurelia_kernel__WEBPACK_IMPORTED_MODULE_0__.ConsoleSink]
    }))
        .enhance({
        host: page,
        component: _app_enhance__WEBPACK_IMPORTED_MODULE_3__.Enhance
    });
}
else {}


/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors"], () => (__webpack_exec__("./startup.ts")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=app.js.map