module.exports =
/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

module.exports = Behavior({
  lifetimes: {
    created: function created() {
      this._computedCache = {};
      this._originalSetData = this.setData;
      this.setData = this._setData;
      this._doingSetData = false;
      this._doingSetProps = false;
    }
  },
  definitionFilter: function definitionFilter(defFields) {
    var computed = defFields.computed || {};
    var computedKeys = Object.keys(computed);
    var properties = defFields.properties || {};
    var propertyKeys = Object.keys(properties);

    // 计算 computed
    var calcComputed = function calcComputed(scope) {
      var needUpdate = {};
      var computedCache = scope._computedCache || scope.data;

      for (var i = 0, len = computedKeys.length; i < len; i++) {
        var key = computedKeys[i];
        var getter = computed[key];

        if (typeof getter === 'function') {
          var value = getter.call(scope);

          if (computedCache[key] !== value) {
            needUpdate[key] = value;
            computedCache[key] = value;
          }
        }
      }

      return needUpdate;
    };

    // 初始化 computed
    var initComputed = function initComputed() {
      defFields.data = defFields.data || {};

      // 先将 properties 里的字段写入到 data 中
      var data = defFields.data;
      var hasOwnProperty = Object.prototype.hasOwnProperty;
      if (propertyKeys.length) {
        // eslint-disable-next-line complexity
        Object.keys(properties).forEach(function (key) {
          var value = properties[key];
          var oldObserver = void 0;

          // eslint-disable-next-line max-len
          if (value === null || value === Number || value === String || value === Boolean || value === Object || value === Array) {
            properties[key] = {
              type: value
            };
          } else if ((typeof value === 'undefined' ? 'undefined' : _typeof(value)) === 'object') {
            if (hasOwnProperty.call(value, 'value')) {
              // 处理值
              data[key] = value.value;
            }

            if (hasOwnProperty.call(value, 'observer') && typeof value.observer === 'function') {
              oldObserver = value.observer;
            }
          }

          // 追加 observer，用于监听变动
          properties[key].observer = function () {
            var originalSetData = this._originalSetData;

            for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
              args[_key] = arguments[_key];
            }

            if (this._doingSetProps) {
              // 调用 setData 设置 properties
              if (oldObserver) oldObserver.apply(this, args);
              return;
            }

            if (this._doingSetData) {
              // eslint-disable-next-line no-console
              console.warn('can\'t call setData in computed getter function!');
              return;
            }

            this._doingSetData = true;

            // 计算 computed
            var needUpdate = calcComputed(this);

            // 做 computed 属性的 setData
            originalSetData.call(this, needUpdate);

            this._doingSetData = false;

            if (oldObserver) oldObserver.apply(this, args);
          };
        });
      }

      // 计算 computed
      calcComputed(defFields, true);
    };

    initComputed();

    defFields.methods = defFields.methods || {};
    defFields.methods._setData = function (data, callback) {
      var originalSetData = this._originalSetData;

      if (this._doingSetData) {
        // eslint-disable-next-line no-console
        console.warn('can\'t call setData in computed getter function!');
        return;
      }

      this._doingSetData = true;

      // TODO 过滤掉 data 中的 computed 字段
      var dataKeys = Object.keys(data);
      for (var i = 0, len = dataKeys.length; i < len; i++) {
        var key = dataKeys[i];

        if (computed[key]) delete data[key];
        if (!this._doingSetProps && propertyKeys.indexOf(key) >= 0) this._doingSetProps = true;
      }

      // 做 data 属性的 setData
      originalSetData.call(this, data, callback);

      // 计算 computed
      var needUpdate = calcComputed(this);

      // 做 computed 属性的 setData
      originalSetData.call(this, needUpdate);

      this._doingSetData = false;
      this._doingSetProps = false;
    };
  }
});

/***/ })
/******/ ]);