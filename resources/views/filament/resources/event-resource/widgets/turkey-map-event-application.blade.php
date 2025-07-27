<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                Şehir Bazlı Başvurular
            </h2>
        </x-slot>
        <div class="turkey-map-container" style="position: relative; width: 100%; height: 600px;">
            <div id="turkey-map" style="width: 100%; height: 100%;"></div>
        </div>

        <style>
            .city-count-label {
                font-family: var(--filament-font-family);
                font-weight: 700;
                font-size: 12px;
                text-anchor: middle;
                dominant-baseline: central;
                pointer-events: none;
                text-shadow: 0 1px 3px rgba(0,0,0,0.8);
                fill: white;
            }

            .city-count-bg {
                fill: rgba(0,0,0,0.75);
                stroke: rgba(255,255,255,0.4);
                stroke-width: 1;
                rx: 8;
                ry: 8;
            }
        </style>

        <script src="https://cdn.jsdelivr.net/npm/d3@7"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const data = @json($this->getData());
                console.log('Harita verisi:', data);

                // Container'ı temizle
                d3.select("#turkey-map").selectAll("*").remove();

                const container = d3.select("#turkey-map");

                const isDarkMode = document.documentElement.classList.contains('dark');

                // Veri varsa renk skalası oluştur
                let colorScale;
                if (data.length > 0) {
                    const maxCount = Math.max(...data.map(d => d.count));
                    colorScale = d3.scaleSequential(d3.interpolateBlues)
                        .domain([0, maxCount]);
                } else {
                    colorScale = () => "#f0f0f0";
                }

                // Tooltip
                const tooltip = d3.select("body").append("div")
                    .attr("class", "turkey-map-tooltip")
                    .style("opacity", 0)
                    .style("position", "absolute")
                    .style("background", "rgba(0, 0, 0, 0.9)")
                    .style("color", "white")
                    .style("padding", "12px")
                    .style("border-radius", "8px")
                    .style("pointer-events", "none")
                    .style("font-size", "14px")
                    .style("z-index", "1000");

                // GitHub reposundaki SVG'yi yükle
                d3.xml("/turkiye.svg")
                    .then(function(svgData) {
                        console.log('SVG yüklendi');

                        const svgElement = svgData.documentElement;
                        container.node().appendChild(svgElement);

                        const svg = d3.select(container.node().querySelector('svg'))
                            .attr("width", "100%")
                            .attr("height", "100%")
                            .attr("viewBox", "0 0 1000 500");

                        // Şehir ID eşleştirme tablosu
                        const cityIdMapping = {
                            'Adana': 'adana',
                            'Adıyaman': 'adiyaman',
                            'Afyonkarahisar': 'afyon',
                            'Ağrı': 'agri',
                            'Amasya': 'amasya',
                            'Ankara': 'ankara',
                            'Antalya': 'antalya',
                            'Artvin': 'artvin',
                            'Aydın': 'aydin',
                            'Balıkesir': 'balikesir',
                            'Bilecik': 'bilecik',
                            'Bingöl': 'bingol',
                            'Bitlis': 'bitlis',
                            'Bolu': 'bolu',
                            'Burdur': 'burdur',
                            'Bursa': 'bursa',
                            'Çanakkale': 'canakkale',
                            'Çankırı': 'cankiri',
                            'Çorum': 'corum',
                            'Denizli': 'denizli',
                            'Diyarbakır': 'diyarbakir',
                            'Edirne': 'edirne',
                            'Elazığ': 'elazig',
                            'Erzincan': 'erzincan',
                            'Erzurum': 'erzurum',
                            'Eskişehir': 'eskisehir',
                            'Gaziantep': 'gaziantep',
                            'Giresun': 'giresun',
                            'Gümüşhane': 'gumushane',
                            'Hakkari': 'hakkari',
                            'Hatay': 'hatay',
                            'Isparta': 'isparta',
                            'Mersin': 'mersin',
                            'İstanbul': 'istanbul',
                            'İzmir': 'izmir',
                            'Kars': 'kars',
                            'Kastamonu': 'kastamonu',
                            'Kayseri': 'kayseri',
                            'Kırklareli': 'kirklareli',
                            'Kırşehir': 'kirsehir',
                            'Kocaeli': 'kocaeli',
                            'Konya': 'konya',
                            'Kütahya': 'kutahya',
                            'Malatya': 'malatya',
                            'Manisa': 'manisa',
                            'Kahramanmaraş': 'kahramanmaras',
                            'Mardin': 'mardin',
                            'Muğla': 'mugla',
                            'Muş': 'mus',
                            'Nevşehir': 'nevsehir',
                            'Niğde': 'nigde',
                            'Ordu': 'ordu',
                            'Rize': 'rize',
                            'Sakarya': 'sakarya',
                            'Samsun': 'samsun',
                            'Siirt': 'siirt',
                            'Sinop': 'sinop',
                            'Sivas': 'sivas',
                            'Tekirdağ': 'tekirdag',
                            'Tokat': 'tokat',
                            'Trabzon': 'trabzon',
                            'Tunceli': 'tunceli',
                            'Şanlıurfa': 'sanliurfa',
                            'Uşak': 'usak',
                            'Van': 'van',
                            'Yozgat': 'yozgat',
                            'Zonguldak': 'zonguldak',
                            'Aksaray': 'aksaray',
                            'Bayburt': 'bayburt',
                            'Karaman': 'karaman',
                            'Kırıkkale': 'kirikkale',
                            'Batman': 'batman',
                            'Şırnak': 'sirnak',
                            'Bartın': 'bartin',
                            'Ardahan': 'ardahan',
                            'Iğdır': 'igdir',
                            'Yalova': 'yalova',
                            'Karabük': 'karabuk',
                            'Kilis': 'kilis',
                            'Osmaniye': 'osmaniye',
                            'Düzce': 'duzce'
                        };

                        // Her şehir için renk ve interaksiyon ekle
                        data.forEach(cityData => {
                            const cityId = cityIdMapping[cityData.name];
                            if (cityId) {
                                const cityElement = svg.select(`#${cityId}`);

                                if (!cityElement.empty()) {
                                    // Şehri renklendir
                                    cityElement
                                        .style("fill", colorScale(cityData.count))
                                        .style("stroke", "#fff")
                                        .style("stroke-width", "1px")
                                        .style("cursor", "pointer");

                                    // Mouse hover olayları
                                    cityElement
                                        .on("mouseover", function(event) {
                                            d3.select(this)
                                                .style("stroke", "#333")
                                                .style("stroke-width", "2px");

                                            tooltip.transition()
                                                .duration(200)
                                                .style("opacity", 1);

                                            tooltip.html(`
                                                <div style="font-weight: bold; margin-bottom: 5px;">${cityData.name}</div>
                                                <div>Başvuru Sayısı: <span style="color: #4dabf7; font-weight: bold;">${cityData.count}</span></div>
                                            `)
                                                .style("left", (event.pageX + 15) + "px")
                                                .style("top", (event.pageY - 10) + "px");
                                        })
                                        .on("mouseout", function() {
                                            d3.select(this)
                                                .style("stroke", "#fff")
                                                .style("stroke-width", "1px");

                                            tooltip.transition()
                                                .duration(300)
                                                .style("opacity", 0);
                                        });

                                    const radius = Math.max(12, Math.min(20, 8 + cityData.count / 5));

                                    const bbox = cityElement.node().getBBox();
                                    const centerX = bbox.x + bbox.width / 2;
                                    const centerY = bbox.y + bbox.height / 2;

                                    svg.append("circle")
                                        .attr("cx", centerX)
                                        .attr("cy", centerY)
                                        .attr("r", radius)
                                        .attr("class", "city-count-bg")
                                        .style("pointer-events", "none");

                                    svg.append("text")
                                        .attr("x", centerX)
                                        .attr("y", centerY)
                                        .attr("text-anchor", "middle")
                                        .attr("dominant-baseline", "middle")
                                        .attr("class", "city-count-label")
                                        .text(cityData.count);
                                }
                            }
                        });

                        // Veri olmayan şehirleri gri renkte göster
                        svg.selectAll("path, polygon")
                            .each(function() {
                                const element = d3.select(this);
                                if (element.style("fill") === "rgb(0, 0, 0)" || !element.style("fill") || element.style("fill") === "black") {
                                    element.style("fill", "#e9ecef");
                                }
                            });

                    })
                    .catch(function(error) {
                        console.error('SVG yüklenirken hata:', error);
                        container.append("div")
                            .style("text-align", "center")
                            .style("padding", "50px")
                            .style("color", "#dc3545")
                            .style("font-size", "18px")
                            .html(`
                                <div>Harita yüklenemedi.</div>
                                <div style="font-size: 14px; margin-top: 10px;">İnternet bağlantınızı kontrol edin.</div>
                            `);
                    });
            });
        </script>
    </x-filament::section>
</x-filament-widgets::widget>
