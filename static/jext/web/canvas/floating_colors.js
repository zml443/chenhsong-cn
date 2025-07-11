var canvas_floating_colors = function(canvasobj, colorvalue){
var browser = !! window.ActiveXObject || "ActiveXObject" in window;

    CAV = {
        FRONT: 0,
        BACK: 1,
        DOUBLE: 2,
        SVGNS: "http://www.w3.org/2000/svg"
    };
    CAV.Array = typeof Float32Array === "function" ? Float32Array : Array;
    CAV.Utils = {
        isNumber: function (a) {
            return !isNaN(parseFloat(a)) && isFinite(a)
        }
    };
    (function () {
        for (var a = 0, b = ["ms", "moz", "webkit", "o"], c = 0; c < b.length && !window.requestAnimationFrame; ++c) window.requestAnimationFrame = window[b[c] + "RequestAnimationFrame"],
        window.cancelAnimationFrame = window[b[c] + "CancelAnimationFrame"] || window[b[c] + "CancelRequestAnimationFrame"];
        if (!window.requestAnimationFrame) window.requestAnimationFrame = function (b) {
            var c = (new Date).getTime(),
                f = Math.max(0, 16 - (c - a)),
                g = window.setTimeout(function () {
                    b(c + f)
                }, f);
            a = c + f;
            return g
        };
        if (!window.cancelAnimationFrame) window.cancelAnimationFrame = function (a) {
            clearTimeout(a)
        }
    })();
    Math.PIM2 = Math.PI * 2;
    Math.PID2 = Math.PI / 2;
    Math.randomInRange = function (a, b) {
        return a + (b - a) * Math.random()
    };
    Math.clamp = function (a, b, c) {
        a = Math.max(a, b);
        return a = Math.min(a, c)
    };
    CAV.Vector3 = {
        create: function (a, b, c) {
            var d = new CAV.Array(3);
            this.set(d, a, b, c);
            return d
        },
        clone: function (a) {
            var b = this.create();
            this.copy(b, a);
            return b
        },
        set: function (a, b, c, d) {
            a[0] = b || 0;
            a[1] = c || 0;
            a[2] = d || 0;
            return this
        },
        setX: function (a, b) {
            a[0] = b || 0;
            return this
        },
        setY: function (a, b) {
            a[1] = b || 0;
            return this
        },
        setZ: function (a, b) {
            a[2] = b || 0;
            return this
        },
        copy: function (a, b) {
            a[0] = b[0];
            a[1] = b[1];
            a[2] = b[2];
            return this
        },
        add: function (a, b) {
            a[0] += b[0];
            a[1] += b[1];
            a[2] += b[2];
            return this
        },
        addVectors: function (a, b, c) {
            a[0] = b[0] + c[0];
            a[1] = b[1] + c[1];
            a[2] = b[2] + c[2];
            return this
        },
        addScalar: function (a, b) {
            a[0] += b;
            a[1] += b;
            a[2] += b;
            return this
        },
        subtract: function (a, b) {
            a[0] -= b[0];
            a[1] -= b[1];
            a[2] -= b[2];
            return this
        },
        subtractVectors: function (a, b, c) {
            a[0] = b[0] - c[0];
            a[1] = b[1] - c[1];
            a[2] = b[2] - c[2];
            return this
        },
        subtractScalar: function (a, b) {
            a[0] -= b;
            a[1] -= b;
            a[2] -= b;
            return this
        },
        multiply: function (a, b) {
            a[0] *= b[0];
            a[1] *= b[1];
            a[2] *= b[2];
            return this
        },
        multiplyVectors: function (a, b, c) {
            a[0] = b[0] * c[0];
            a[1] = b[1] * c[1];
            a[2] = b[2] * c[2];
            return this
        },
        multiplyScalar: function (a, b) {
            a[0] *= b;
            a[1] *= b;
            a[2] *= b;
            return this
        },
        divide: function (a, b) {
            a[0] /= b[0];
            a[1] /= b[1];
            a[2] /= b[2];
            return this
        },
        divideVectors: function (a, b, c) {
            a[0] = b[0] / c[0];
            a[1] = b[1] / c[1];
            a[2] = b[2] / c[2];
            return this
        },
        divideScalar: function (a, b) {
            b !== 0 ? (a[0] /= b, a[1] /= b, a[2] /= b) : (a[0] = 0, a[1] = 0, a[2] = 0);
            return this
        },
        cross: function (a, b) {
            var c = a[0],
                d = a[1],
                e = a[2];
            a[0] = d * b[2] - e * b[1];
            a[1] = e * b[0] - c * b[2];
            a[2] = c * b[1] - d * b[0];
            return this
        },
        crossVectors: function (a, b, c) {
            a[0] = b[1] * c[2] - b[2] * c[1];
            a[1] = b[2] * c[0] - b[0] * c[2];
            a[2] = b[0] * c[1] - b[1] * c[0];
            return this
        },
        min: function (a, b) {
            a[0] < b && (a[0] = b);
            a[1] < b && (a[1] = b);
            a[2] < b && (a[2] = b);
            return this
        },
        max: function (a, b) {
            a[0] > b && (a[0] = b);
            a[1] > b && (a[1] = b);
            a[2] > b && (a[2] = b);
            return this
        },
        clamp: function (a, b, c) {
            this.min(a, b);
            this.max(a, c);
            return this
        },
        limit: function (a, b, c) {
            var d = this.length(a);
            b !== null && d < b ? this.setLength(a, b) : c !== null && d > c && this.setLength(a, c);
            return this
        },
        dot: function (a, b) {
            return a[0] * b[0] + a[1] * b[1] + a[2] * b[2]
        },
        normalise: function (a) {
            return this.divideScalar(a, this.length(a))
        },
        negate: function (a) {
            return this.multiplyScalar(a, -1)
        },
        distanceSquared: function (a, b) {
            var c = a[0] - b[0],
                d = a[1] - b[1],
                e = a[2] - b[2];
            return c * c + d * d + e * e
        },
        distance: function (a, b) {
            return Math.sqrt(this.distanceSquared(a, b))
        },
        lengthSquared: function (a) {
            return a[0] * a[0] + a[1] * a[1] + a[2] * a[2]
        },
        length: function (a) {
            return Math.sqrt(this.lengthSquared(a))
        },
        setLength: function (a, b) {
            var c = this.length(a);
            c !== 0 && b !== c && this.multiplyScalar(a, b / c);
            return this
        }
    };
    CAV.Vector4 = {
        create: function (a, b, c) {
            var d = new CAV.Array(4);
            this.set(d, a, b, c);
            return d
        },
        set: function (a, b, c, d, e) {
            a[0] = b || 0;
            a[1] = c || 0;
            a[2] = d || 0;
            a[3] = e || 0;
            return this
        },
        setX: function (a, b) {
            a[0] = b || 0;
            return this
        },
        setY: function (a, b) {
            a[1] = b || 0;
            return this
        },
        setZ: function (a, b) {
            a[2] = b || 0;
            return this
        },
        setW: function (a, b) {
            a[3] = b || 0;
            return this
        },
        add: function (a, b) {
            a[0] += b[0];
            a[1] += b[1];
            a[2] += b[2];
            a[3] += b[3];
            return this
        },
        multiplyVectors: function (a, b, c) {
            a[0] = b[0] * c[0];
            a[1] = b[1] * c[1];
            a[2] = b[2] * c[2];
            a[3] = b[3] * c[3];
            return this
        },
        multiplyScalar: function (a, b) {
            a[0] *= b;
            a[1] *= b;
            a[2] *= b;
            a[3] *= b;
            return this
        },
        min: function (a, b) {
            a[0] < b && (a[0] = b);
            a[1] < b && (a[1] = b);
            a[2] < b && (a[2] = b);
            a[3] < b && (a[3] = b);
            return this
        },
        max: function (a, b) {
            a[0] > b && (a[0] = b);
            a[1] > b && (a[1] = b);
            a[2] > b && (a[2] = b);
            a[3] > b && (a[3] = b);
            return this
        },
        clamp: function (a, b, c) {
            this.min(a, b);
            this.max(a, c);
            return this
        }
    };
    CAV.Color = function (a, b) {
        this.rgba = CAV.Vector4.create();
        this.hex = a || "#000000";
        this.opacity = CAV.Utils.isNumber(b) ? b : 1;
        this.set(this.hex, this.opacity)
    };
    CAV.Color.prototype = {
        set: function (a, b) {
            var a = a.replace("#", ""),
                c = a.length / 3;
            this.rgba[0] = parseInt(a.substring(c * 0, c * 1), 16) / 255;
            this.rgba[1] = parseInt(a.substring(c * 1, c * 2), 16) / 255;
            this.rgba[2] = parseInt(a.substring(c * 2, c * 3), 16) / 255;
            this.rgba[3] = CAV.Utils.isNumber(b) ? b : this.rgba[3];
            return this
        },
        hexify: function (a) {
            a = Math.ceil(a * 255).toString(16);
            a.length === 1 && (a = "0" + a);
            return a
        },
        format: function () {
            var a = this.hexify(this.rgba[0]),
                b = this.hexify(this.rgba[1]),
                c = this.hexify(this.rgba[2]);
            return this.hex = "#" + a + b + c
        }
    };
    CAV.Object = function () {
        this.position = CAV.Vector3.create()
    };
    CAV.Object.prototype = {
        setPosition: function (a, b, c) {
            CAV.Vector3.set(this.position, a, b, c);
            return this
        }
    };
    CAV.Light = function (a, b) {
        CAV.Object.call(this);
        this.ambient = new CAV.Color(a || "#FFFFFF");
        this.diffuse = new CAV.Color(b || "#FFFFFF");
        this.ray = CAV.Vector3.create()
    };
    CAV.Light.prototype = Object.create(CAV.Object.prototype);
    CAV.Vertex = function (a, b, c) {
        this.position = CAV.Vector3.create(a, b, c)
    };
    CAV.Vertex.prototype = {
        setPosition: function (a, b, c) {
            CAV.Vector3.set(this.position, a, b, c);
            return this
        }
    };
    CAV.Triangle = function (a, b, c) {
        this.a = a || new CAV.Vertex;
        this.b = b || new CAV.Vertex;
        this.c = c || new CAV.Vertex;
        this.vertices = [this.a, this.b, this.c];
        this.u = CAV.Vector3.create();
        this.v = CAV.Vector3.create();
        this.centroid = CAV.Vector3.create();
        this.normal = CAV.Vector3.create();
        this.color = new CAV.Color;
        this.polygon = document.createElementNS(CAV.SVGNS, "polygon");
        this.polygon.setAttributeNS(null, "stroke-linejoin", "round");
        this.polygon.setAttributeNS(null, "stroke-miterlimit", "1");
        this.polygon.setAttributeNS(null, "stroke-width", "1");
        this.computeCentroid();
        this.computeNormal()
    };
    CAV.Triangle.prototype = {
        computeCentroid: function () {
            this.centroid[0] = this.a.position[0] + this.b.position[0] + this.c.position[0];
            this.centroid[1] = this.a.position[1] + this.b.position[1] + this.c.position[1];
            this.centroid[2] = this.a.position[2] + this.b.position[2] + this.c.position[2];
            CAV.Vector3.divideScalar(this.centroid, 3);
            return this
        },
        computeNormal: function () {
            CAV.Vector3.subtractVectors(this.u, this.b.position, this.a.position);
            CAV.Vector3.subtractVectors(this.v, this.c.position, this.a.position);
            CAV.Vector3.crossVectors(this.normal, this.u, this.v);
            CAV.Vector3.normalise(this.normal);
            return this
        }
    };
    CAV.Geometry = function () {
        this.vertices = [];
        this.triangles = [];
        this.dirty = false
    };
    CAV.Geometry.prototype = {
        update: function () {
            if (this.dirty) {
                var a, b;
                for (a = this.triangles.length - 1; a >= 0; a--) b = this.triangles[a],
                b.computeCentroid(),
                b.computeNormal();
                this.dirty = false
            }
            return this
        }
    };
    CAV.Plane = function (a, b, c, d) {
        CAV.Geometry.call(this);
        this.width = a || 100;
        this.height = b || 100;
        this.segments = c || 4;
        this.slices = d || 4;
        this.segmentWidth = this.width / this.segments;
        this.sliceHeight = this.height / this.slices;
        var e, f, g, c = [];
        e = this.width * -0.5;
        f = this.height * 0.5;
        for (a = 0; a <= this.segments; a++) {
            c.push([]);
            for (b = 0; b <= this.slices; b++) d = new CAV.Vertex(e + a * this.segmentWidth, f - b * this.sliceHeight),
            c[a].push(d),
            this.vertices.push(d)
        }
        for (a = 0; a < this.segments; a++) for (b = 0; b < this.slices; b++) d = c[a + 0][b + 0],
        e = c[a + 0][b + 1],
        f = c[a + 1][b + 0],
        g = c[a + 1][b + 1],
        t0 = new CAV.Triangle(d, e, f),
        t1 = new CAV.Triangle(f, e, g),
        this.triangles.push(t0, t1)
    };
    CAV.Plane.prototype = Object.create(CAV.Geometry.prototype);
    CAV.Material = function (a, b) {
        this.ambient = new CAV.Color(a || "#444444");
        this.diffuse = new CAV.Color(b || "#FFFFFF");
        this.slave = new CAV.Color
    };
    CAV.Mesh = function (a, b) {
        CAV.Object.call(this);
        this.geometry = a || new CAV.Geometry;
        this.material = b || new CAV.Material;
        this.side = CAV.FRONT;
        this.visible = true
    };
    CAV.Mesh.prototype = Object.create(CAV.Object.prototype);
    CAV.Mesh.prototype.update = function (a, b) {
        var c, d, e, f, g;
        this.geometry.update();
        if (b) for (c = this.geometry.triangles.length - 1; c >= 0; c--) {
            d = this.geometry.triangles[c];
            CAV.Vector4.set(d.color.rgba);
            for (e = a.length - 1; e >= 0; e--) f = a[e],
            CAV.Vector3.subtractVectors(f.ray, f.position, d.centroid),
            CAV.Vector3.normalise(f.ray),
            g = CAV.Vector3.dot(d.normal, f.ray),
            this.side === CAV.FRONT ? g = Math.max(g, 0) : this.side === CAV.BACK ? g = Math.abs(Math.min(g, 0)) : this.side === CAV.DOUBLE && (g = Math.max(Math.abs(g), 0)),
            CAV.Vector4.multiplyVectors(this.material.slave.rgba, this.material.ambient.rgba, f.ambient.rgba),
            CAV.Vector4.add(d.color.rgba, this.material.slave.rgba),
            CAV.Vector4.multiplyVectors(this.material.slave.rgba, this.material.diffuse.rgba, f.diffuse.rgba),
            CAV.Vector4.multiplyScalar(this.material.slave.rgba, g),
            CAV.Vector4.add(d.color.rgba, this.material.slave.rgba);
            CAV.Vector4.clamp(d.color.rgba, 0, 1)
        }
        return this
    };
    CAV.Scene = function () {
        this.meshes = [];
        this.lights = []
    };
    CAV.Scene.prototype = {
        add: function (a) {
            a instanceof CAV.Mesh && !~this.meshes.indexOf(a) ? this.meshes.push(a) : a instanceof CAV.Light && !~this.lights.indexOf(a) && this.lights.push(a);
            return this
        },
        remove: function (a) {
            a instanceof CAV.Mesh && ~this.meshes.indexOf(a) ? this.meshes.splice(this.meshes.indexOf(a), 1) : a instanceof CAV.Light && ~this.lights.indexOf(a) && this.lights.splice(this.lights.indexOf(a), 1);
            return this
        }
    };
    CAV.Renderer = function () {
        this.halfHeight = this.halfWidth = this.height = this.width = 0
    };
    CAV.Renderer.prototype = {
        setSize: function (a, b) {
            if (!(this.width === a && this.height === b)) return this.width = a,
            this.height = b,
            this.halfWidth = this.width * 0.5,
            this.halfHeight = this.height * 0.5,
            this
        },
        clear: function () {
            return this
        },
        render: function () {
            return this
        }
    };
    CAV.CanvasRenderer = function () {
        CAV.Renderer.call(this);
        this.element = document.createElement("canvas");
        this.element.style.display = "block";
        this.context = this.element.getContext("2d");
        this.setSize(this.element.width, this.element.height)
    };
    CAV.CanvasRenderer.prototype = Object.create(CAV.Renderer.prototype);
    CAV.CanvasRenderer.prototype.setSize = function (a, b) {
        CAV.Renderer.prototype.setSize.call(this, a, b);
        this.element.width = a;
        this.element.height = b;
        this.context.setTransform(1, 0, 0, -1, this.halfWidth, this.halfHeight);
        return this
    };
    CAV.CanvasRenderer.prototype.clear = function () {
        CAV.Renderer.prototype.clear.call(this);
        this.context.clearRect(-this.halfWidth, -this.halfHeight, this.width, this.height);
        return this
    };
    CAV.CanvasRenderer.prototype.render = function (a) {
        CAV.Renderer.prototype.render.call(this, a);
        var b, c, d, e, f;
        this.clear();
        this.context.lineJoin = "round";
        this.context.lineWidth = 1;
        for (b = a.meshes.length - 1; b >= 0; b--) if (c = a.meshes[b], c.visible) {
            c.update(a.lights, true);
            for (d = c.geometry.triangles.length - 1; d >= 0; d--) e = c.geometry.triangles[d],
            f = e.color.format(),
            this.context.beginPath(),
            this.context.moveTo(e.a.position[0], e.a.position[1]),
            this.context.lineTo(e.b.position[0], e.b.position[1]),
            this.context.lineTo(e.c.position[0], e.c.position[1]),
            this.context.closePath(),
            this.context.strokeStyle = f,
            this.context.fillStyle = f,
            this.context.stroke(),
            this.context.fill()
        }
        return this
    };

    var t = {
        width: 1.5,
        height: 1.5,
        depth: 10,
        segments: 30,
        slices: 3,
        xRange: 0.8,
        yRange: 0.1,
        zRange: 1,
        ambient: colorvalue[0],
        diffuse: colorvalue[1],
        speed: 0.0005
    };
    var G = {
        count: 2,
        xyScalar: 100,
        zOffset: 2,
        ambient: colorvalue[2],
        diffuse: colorvalue[3],
        speed: 0.001,
        gravity: 120,
        dampening: 0.95,
        minLimit: 100,
        maxLimit: null,
        minDistance: 20,
        maxDistance: 400,
        autopilot: false,
        draw: false,
        bounds: CAV.Vector3.create(),
        step: CAV.Vector3.create(Math.randomInRange(0.2, 1), Math.randomInRange(0.2, 1), Math.randomInRange(0.2, 1))
    };
    var m = "canvas";
    var E = "svg";
    var x = {
        renderer: m
    };
    var i, n = Date.now();
    var L = CAV.Vector3.create();
    var k = CAV.Vector3.create();
    var w = canvasobj[0];
    var D, I, h, q, y;
    var g;
    var r;

    function C() {
        F();
        p();
        s();
        B();
        K(w.offsetWidth||6000, w.offsetHeight||1200);
        o()
    }
    function F() {
        g = new CAV.CanvasRenderer();
        H(x.renderer)
    }
    function H(N) {
        if (D) {
            w.removeChild(D.element)
        }
        switch (N) {
        case m:
            D = g;
            break
        }
        D.setSize(w.offsetWidth, w.offsetHeight);
        w.appendChild(D.element)
    }
    function p() {
        I = new CAV.Scene()
    }
    function s() {
        I.remove(h);
        D.clear();
        q = new CAV.Plane(t.width * D.width, t.height * D.height, t.segments, t.slices);
        y = new CAV.Material(t.ambient, t.diffuse);
        h = new CAV.Mesh(q, y);
        I.add(h);
        var N, O;
        for (N = q.vertices.length - 1; N >= 0; N--) {
            O = q.vertices[N];
            O.anchor = CAV.Vector3.clone(O.position);
            O.step = CAV.Vector3.create(Math.randomInRange(0.2, 1), Math.randomInRange(0.2, 1), Math.randomInRange(0.2, 1));
            O.time = Math.randomInRange(0, Math.PIM2)
        }
    }
    function B() {
        var O, N;
        for (O = I.lights.length - 1; O >= 0; O--) {
            N = I.lights[O];
            I.remove(N)
        }
        D.clear();
        for (O = 0; O < G.count; O++) {
            N = new CAV.Light(G.ambient, G.diffuse);
            N.ambientHex = N.ambient.format();
            N.diffuseHex = N.diffuse.format();
            I.add(N);
            N.mass = Math.randomInRange(0.5, 1);
            N.velocity = CAV.Vector3.create();
            N.acceleration = CAV.Vector3.create();
            N.force = CAV.Vector3.create()
        }
    }
    function K(O, N) {
        D.setSize(O, N);
        CAV.Vector3.set(L, D.halfWidth, D.halfHeight);
        s()
    }
    function o() {
        i = Date.now() - n;
        u();
        M();
        requestAnimationFrame(o)
    }
    function u() {
        var Q, P, O, R, T, V, U, S = t.depth / 2;
        CAV.Vector3.copy(G.bounds, L);
        CAV.Vector3.multiplyScalar(G.bounds, G.xyScalar);
        CAV.Vector3.setZ(k, G.zOffset);
        for (R = I.lights.length - 1; R >= 0; R--) {
            T = I.lights[R];
            CAV.Vector3.setZ(T.position, G.zOffset);
            var N = Math.clamp(CAV.Vector3.distanceSquared(T.position, k), G.minDistance, G.maxDistance);
            var W = G.gravity * T.mass / N;
            CAV.Vector3.subtractVectors(T.force, k, T.position);
            CAV.Vector3.normalise(T.force);
            CAV.Vector3.multiplyScalar(T.force, W);
            CAV.Vector3.set(T.acceleration);
            CAV.Vector3.add(T.acceleration, T.force);
            CAV.Vector3.add(T.velocity, T.acceleration);
            CAV.Vector3.multiplyScalar(T.velocity, G.dampening);
            CAV.Vector3.limit(T.velocity, G.minLimit, G.maxLimit);
            CAV.Vector3.add(T.position, T.velocity)
        }
        for (V = q.vertices.length - 1; V >= 0; V--) {
            U = q.vertices[V];
            Q = Math.sin(U.time + U.step[0] * i * t.speed);
            P = Math.cos(U.time + U.step[1] * i * t.speed);
            O = Math.sin(U.time + U.step[2] * i * t.speed);
            CAV.Vector3.set(U.position, t.xRange * q.segmentWidth * Q, t.yRange * q.sliceHeight * P, t.zRange * S * O - S);
            CAV.Vector3.add(U.position, U.anchor)
        }
        q.dirty = true
    }
    function M() {
        D.render(I)
    }
    function J(O) {
        var Q, N, S = O;
        var P = function (T) {
            for (Q = 0, l = I.lights.length; Q < l; Q++) {
                N = I.lights[Q];
                N.ambient.set(T);
                N.ambientHex = N.ambient.format()
            }
        };
        var R = function (T) {
            for (Q = 0, l = I.lights.length; Q < l; Q++) {
                N = I.lights[Q];
                N.diffuse.set(T);
                N.diffuseHex = N.diffuse.format()
            }
        };
        return {
            set: function () {
                P(S[0]);
                R(S[1])
            }
        }
    }
    function A(N) {
        CAV.Vector3.set(k, N.x, D.height - N.y);
        CAV.Vector3.subtract(k, L)
    }
    function j(N) {
        K(w.offsetWidth, w.offsetHeight);
        M()
    }
    C();
};

$('[jextstyle]').append('[canvas-floating-colors] canvas{width:100%;height:100%;}');
$.task.push(function () {
    _('[canvas-floating-colors]').each(function(i,e,v,c){
        e = $(this);
        v = ['#008cd6', '#FFFFFF', '#008cd6', '#444444'];
        c = e.attr('canvas-floating-colors');
        v[0] = c || v[0];
        v[2] = c || v[2];
        canvas_floating_colors(e, v);
    });
});

