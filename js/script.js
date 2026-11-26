let allProducts = [];
let allCategories = [];
let selectedCategoryId = "";
let maxPriceGlobal = 200;

document.addEventListener("DOMContentLoaded", () => {
  const productGrid = document.getElementById("product-grid");
  if (!productGrid) return;

  fetch(`api_productos.php?t=${Date.now()}`, { cache: "no-store" })
    .then((response) => response.json())
    .then((data) => {
      if (data.error) {
        console.error("API Error:", data.error);
        productGrid.innerHTML =
          '<p class="text-danger text-center py-5">No se pudo cargar el catálogo en este momento.</p>';
        return;
      }

      if (Array.isArray(data)) {
        allProducts = data;
        allCategories = [];
      } else {
        allProducts = data.productos || [];
        allCategories = data.categorias || [];
      }

      initCatalog();
    })
    .catch((error) => {
      console.error("Fetch error:", error);
      productGrid.innerHTML =
        '<p class="text-danger text-center py-5">Error de conexión al cargar el catálogo.</p>';
    });
});

function formatearPrecio(valor) {
  return Number(valor).toLocaleString("es-PE", {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  });
}

function initCatalog() {
  const categorySelect = document.getElementById("categorySelect");
  const searchInput = document.getElementById("searchInput");
  const searchButton = document.getElementById("searchButton");
  const priceRange = document.getElementById("priceRange");
  const priceLabel = document.getElementById("priceLabel");
  const btnReset = document.getElementById("btnResetFilters");
  const btnVerTodo = document.getElementById("btnVerTodo");
  const btnLimpiarBusqueda = document.getElementById("btnLimpiarBusqueda");

  // Ajustar dinámicamente el precio máximo al producto más caro del catálogo
  const precios = allProducts.map((p) => Number(p.price) || 0);
  maxPriceGlobal = Math.max(200, Math.ceil(Math.max(0, ...precios)));

  if (priceRange && priceLabel) {
    priceRange.max = String(maxPriceGlobal);
    priceRange.step = maxPriceGlobal > 1000 ? "10" : "1";
    priceRange.value = String(maxPriceGlobal);
    priceLabel.textContent = `S/ ${formatearPrecio(maxPriceGlobal)}`;
  }

  // Detectar ?cat=... en URL (compatibilidad con enlaces de inicio)
  const urlParams = new URLSearchParams(window.location.search);
  const preselectedCat = (urlParams.get("cat") || "").trim().toLowerCase();
  if (preselectedCat) {
    const match = allCategories.find((c) => {
      const nom = c.nombre.toLowerCase();
      return (
        String(c.id) === preselectedCat ||
        nom.includes(preselectedCat) ||
        (preselectedCat === "medicamentos" && nom.includes("analg"))
      );
    });
    if (match) selectedCategoryId = String(match.id);
  }

  renderCategoryFilters();

  if (categorySelect) {
    categorySelect.addEventListener("change", (e) => {
      selectedCategoryId = e.target.value;
      syncCategoryUI();
      renderProducts();
    });
  }

  if (priceRange && priceLabel) {
    priceRange.addEventListener("input", (e) => {
      const val = Number(e.target.value);
      priceLabel.textContent = `S/ ${formatearPrecio(val)}`;
      actualizarBotonReset();
      const term = searchInput ? searchInput.value.trim() : "";
      if (term) {
        performSearch(term);
      } else {
        renderProducts();
      }
    });
  }

  if (searchButton && searchInput) {
    searchButton.addEventListener("click", () => performSearch(searchInput.value));
    searchInput.addEventListener("keypress", (e) => {
      if (e.key === "Enter") performSearch(searchInput.value);
    });
  }

  if (btnReset) {
    btnReset.addEventListener("click", resetAllFilters);
  }
  if (btnVerTodo) {
    btnVerTodo.addEventListener("click", resetAllFilters);
  }
  if (btnLimpiarBusqueda) {
    btnLimpiarBusqueda.addEventListener("click", () => {
      if (searchInput) searchInput.value = "";
      performSearch("");
    });
  }

  renderProducts();
}

function resetAllFilters() {
  selectedCategoryId = "";
  const searchInput = document.getElementById("searchInput");
  const priceRange = document.getElementById("priceRange");
  const priceLabel = document.getElementById("priceLabel");

  if (searchInput) searchInput.value = "";
  if (priceRange) priceRange.value = String(maxPriceGlobal);
  if (priceLabel) priceLabel.textContent = `S/ ${formatearPrecio(maxPriceGlobal)}`;

  syncCategoryUI();
  performSearch("");
}

function actualizarBotonReset() {
  const btnReset = document.getElementById("btnResetFilters");
  const priceRange = document.getElementById("priceRange");
  if (!btnReset) return;

  const precioFiltrado = priceRange && Number(priceRange.value) < maxPriceGlobal;
  const hayFiltro = Boolean(selectedCategoryId) || Boolean(precioFiltrado);
  btnReset.classList.toggle("d-none", !hayFiltro);
}

function renderCategoryFilters() {
  const select = document.getElementById("categorySelect");
  const list = document.getElementById("categoryList");
  if (!select || !list) return;

  select.textContent = "";
  const optAll = document.createElement("option");
  optAll.value = "";
  optAll.textContent = `Todas las categorías (${allProducts.length})`;
  select.appendChild(optAll);

  list.textContent = "";

  // Botón "Todas"
  const btnAll = document.createElement("button");
  btnAll.type = "button";
  btnAll.className = "cat-pill-item";
  btnAll.dataset.catId = "";
  const spanAllNom = document.createElement("span");
  spanAllNom.textContent = "Todas las categorías";
  const spanAllCnt = document.createElement("span");
  spanAllCnt.className = "cat-pill-count";
  spanAllCnt.textContent = String(allProducts.length);
  btnAll.append(spanAllNom, spanAllCnt);
  btnAll.addEventListener("click", () => {
    selectedCategoryId = "";
    syncCategoryUI();
    renderProducts();
  });
  list.appendChild(btnAll);

  for (const cat of allCategories) {
    const opt = document.createElement("option");
    opt.value = String(cat.id);
    opt.textContent = `${cat.nombre} (${cat.total_productos})`;
    select.appendChild(opt);

    const btn = document.createElement("button");
    btn.type = "button";
    btn.className = "cat-pill-item";
    btn.dataset.catId = String(cat.id);

    const nom = document.createElement("span");
    nom.textContent = cat.nombre;

    const cnt = document.createElement("span");
    cnt.className = "cat-pill-count";
    cnt.textContent = String(cat.total_productos);

    btn.append(nom, cnt);
    btn.addEventListener("click", () => {
      selectedCategoryId = String(cat.id);
      syncCategoryUI();
      renderProducts();
    });
    list.appendChild(btn);
  }

  syncCategoryUI();
}

function syncCategoryUI() {
  const select = document.getElementById("categorySelect");
  if (select) select.value = selectedCategoryId;

  document.querySelectorAll("#categoryList .cat-pill-item").forEach((btn) => {
    btn.classList.toggle("active", btn.dataset.catId === selectedCategoryId);
  });

  actualizarBotonReset();
}

function crearTarjetaProducto(product, colClass) {
  const col = document.createElement("div");
  col.className = colClass;

  const card = document.createElement("div");
  card.style.cssText =
    "background-color:white;border-radius:12px;padding:15px;box-shadow:6px 6px 15px rgba(0,0,0,0.08);height:100%;display:flex;flex-direction:column;";

  const imgWrap = document.createElement("div");
  imgWrap.className = "text-center mb-3";
  imgWrap.style.cssText =
    "flex-grow:1;display:flex;align-items:center;justify-content:center;height:130px;";

  const linkDet = document.createElement("a");
  linkDet.href = `detalles.php?id=${product.id}`;

  const img = document.createElement("img");
  img.loading = "lazy";
  img.src = product.image;
  img.alt = product.name;
  img.style.cssText =
    "max-height:120px;max-width:100%;object-fit:contain;cursor:pointer;transition:transform 0.2s;";
  img.addEventListener("mouseover", () => (img.style.transform = "scale(1.05)"));
  img.addEventListener("mouseout", () => (img.style.transform = "scale(1)"));
  img.onerror = function () {
    this.src = "https://placehold.co/150x150/f0f0f0/666?text=Producto";
  };

  linkDet.appendChild(img);
  imgWrap.appendChild(linkDet);

  const info = document.createElement("div");
  info.className = "text-start mt-auto";

  const nom = document.createElement("div");
  nom.style.cssText =
    "font-size:13.5px;color:#374151;font-weight:600;line-height:1.3;min-height:36px;margin-bottom:4px;";
  nom.textContent = product.name;

  const pres = document.createElement("div");
  pres.style.cssText = "font-size:11.5px;color:#6b7280;margin-bottom:6px;";
  pres.textContent = product.gramaje || "";

  const precio = document.createElement("div");
  precio.className = "fw-bold";
  precio.style.cssText = "color:#00A859;font-size:16px;margin-bottom:10px;";
  precio.textContent = `S/ ${formatearPrecio(product.price)}`;

  const wa = document.createElement("a");
  wa.href = `https://wa.me/${typeof globalWhatsApp !== "undefined" ? globalWhatsApp : "519258354599"}?text=${encodeURIComponent(`Hola, deseo comprar ${product.name}`)}`;
  wa.target = "_blank";
  wa.className = "btn w-100 fw-bold text-white";
  wa.style.cssText =
    "background-color:#00A859;font-size:11px;border-radius:8px;padding:6px 0;";
  wa.textContent = "Consultar vía Whatsapp";

  info.append(nom, pres, precio, wa);

  if (Number(product.stock) === 0 || Number(product.activo) === 0) {
    const sinStock = document.createElement("div");
    sinStock.className = "text-danger fw-bold mt-2 text-center";
    sinStock.style.fontSize = "12px";
    sinStock.innerHTML = '<i class="fa-solid fa-circle-xmark"></i> Producto Sin Stock';
    info.appendChild(sinStock);
  }

  card.append(imgWrap, info);
  col.appendChild(card);
  return col;
}

function performSearch(term) {
  term = term.trim().toLowerCase();
  const grid = document.getElementById("product-grid");
  const sidebar = document.getElementById("catalog-sidebar");
  const mainContent = document.getElementById("catalog-main-content");
  const searchFilterBar = document.getElementById("search-filter-bar");
  const searchHeader = document.getElementById("search-header");
  const searchTitle = document.getElementById("search-title");
  const searchCount = document.getElementById("search-count");

  grid.textContent = "";

  if (term === "") {
    sidebar.style.display = "block";
    mainContent.className = "col-lg-9 col-md-8";
    searchFilterBar.style.display = "flex";
    searchHeader.style.display = "none";
    renderProducts();
    return;
  }

  sidebar.style.display = "none";
  mainContent.className = "col-12";
  searchFilterBar.style.display = "none";
  searchHeader.style.display = "block";
  searchTitle.textContent = `Resultados para: "${term}"`;

  const priceRangeInput = document.getElementById("priceRange");
  const maxPrice = priceRangeInput ? parseFloat(priceRangeInput.value) : Infinity;

  const filtered = allProducts.filter((p) => {
    const matchText =
      p.name.toLowerCase().includes(term) ||
      (p.sku && p.sku.toLowerCase().includes(term)) ||
      (p.category_name && p.category_name.toLowerCase().includes(term));
    return matchText && Number(p.price) <= maxPrice;
  });

  searchCount.textContent = `Encontramos ${filtered.length} producto${filtered.length !== 1 ? "s" : ""}`;

  if (filtered.length > 0) {
    const row = document.createElement("div");
    row.className = "row g-4";
    for (const product of filtered) {
      row.appendChild(crearTarjetaProducto(product, "col-lg-3 col-md-4 col-sm-6"));
    }
    grid.appendChild(row);
  } else {
    const vacio = document.createElement("div");
    vacio.className = "text-center py-5";
    vacio.style.cssText =
      "background-color:#f9f9f9;border-radius:12px;max-width:600px;margin:0 auto;";
    vacio.innerHTML = `
      <div style="width:90px;height:90px;background-color:#e5e7eb;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
        <i class="fa-solid fa-magnifying-glass" style="font-size:36px;color:#9ca3af;"></i>
      </div>
      <h4 class="fw-bold text-dark mb-2">No encontramos este producto</h4>
      <p class="text-muted small px-4 mb-4">Intenta con otro término o revisa el catálogo completo.</p>
    `;
    const btnBack = document.createElement("button");
    btnBack.type = "button";
    btnBack.className = "btn fw-bold px-4 rounded-pill";
    btnBack.style.cssText =
      "background-color:#00A859;color:white;font-size:13px;";
    btnBack.textContent = "Ver Catálogo Completo";
    btnBack.addEventListener("click", resetAllFilters);
    vacio.appendChild(btnBack);
    grid.appendChild(vacio);
  }
}

function renderProducts() {
  const grid = document.getElementById("product-grid");
  grid.textContent = "";

  const priceRangeInput = document.getElementById("priceRange");
  const maxPrice = priceRangeInput ? parseFloat(priceRangeInput.value) : Infinity;

  const filtrados = allProducts.filter((p) => {
    const okCat = !selectedCategoryId || String(p.categoria_id) === selectedCategoryId;
    const okPrice = Number(p.price) <= maxPrice;
    return okCat && okPrice;
  });

  if (filtrados.length === 0) {
    const p = document.createElement("p");
    p.className = "text-muted mt-5 text-center";
    p.textContent = "No hay productos que coincidan con los filtros seleccionados.";
    grid.appendChild(p);
    return;
  }

  // Agrupar dinámicamente por nombre real de categoría
  const grupos = new Map();
  for (const prod of filtrados) {
    const nombreCat = prod.category_name || "Otros";
    if (!grupos.has(nombreCat)) grupos.set(nombreCat, []);
    grupos.get(nombreCat).push(prod);
  }

  for (const [nombreCat, items] of grupos.entries()) {
    const titleBadge = document.createElement("div");
    titleBadge.className = "mb-4 mt-4";

    const span = document.createElement("span");
    span.style.cssText =
      "background-color:#00A859;color:white;padding:6px 20px;border-radius:8px;font-weight:bold;font-size:15px;display:inline-block;";
    span.textContent = nombreCat.toUpperCase();
    titleBadge.appendChild(span);
    grid.appendChild(titleBadge);

    const row = document.createElement("div");
    row.className = "row g-4";
    for (const product of items) {
      row.appendChild(crearTarjetaProducto(product, "col-lg-4 col-md-6 col-sm-6"));
    }
    grid.appendChild(row);
  }
}
