@extends('../../layouts/app')

@section('container')
<div class="my-5 mx-4">
    <h2>Detail Program {{ $program->nama_program.' '.$program->tahun }}</h2>
    <hr>
    {{-- <form id="detailProgram"> --}}
        <div class="form-group mb-3">
            {{-- <textarea class="form-control" name="nama_program" id="nama_program">{{ $program->deskripsi }}</textarea> --}}
            <div class="row">
                <div class="col-10">
                    <h5>Nama Program</h5>
                    <input class="form-control" type="text" name="nama_program" id="nama_program" value="{{ $program->nama_program }}" readonly>
                </div>
                <div class="col-2">
                    <h5>Tahun</h5>
                    <input class="form-control" type="text" name="tahun" id="tahun" value="{{ $program->tahun }}" readonly>
                </div>
            </div>
        </div>
        <div class="form-group mb-3">
            <h3>Deskripsi</h3>
            <textarea class="form-control" name="deskripsi" id="deskirpsi" readonly>{{ $program->deskripsi }}</textarea>
            {{-- <input class="form-control" type="text" value="{{ $program->deskripsi }}"> --}}
        </div>
        <div class="form-group mb-3">
            <h3>Kegiatan</h3>
            <div class="card">
                <div class="row card-body" id="listKegiatan">
                </div>
            </div>
        </div>
        <div class="form-group mb-3">
            <h3>Tahapan</h3>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="row card-body">
                            <div class="timeline">
                                <div class="timeline__wrap">
                                    <div class="timeline__items">
                                        <?php $first = false; $active = false; $i=0; $count=count($tahaps); ?>
                                        @foreach($tahaps as $item) 
                                            <?php $i++?>
                                            @if ($active == false)
                                                <div class="timeline__item @if($first == false) first <?php $first = true; ?> @endif @if($i == $count) end @endif @if((strtotime(date("Y-m-d H:i:s")) >= strtotime($item->mulai)) && (strtotime(date("Y-m-d H:i:s")) <= strtotime($item->selesai))) active <?php $active = true; ?> @else actived @endif">
                                                    <div class="timeline__content @if((strtotime(date("Y-m-d H:i:s")) >= strtotime($item->mulai)) && (strtotime(date("Y-m-d H:i:s")) <= strtotime($item->selesai))) active @endif">
                                                        <h5>{{ $item->tahap->nama_tahap }}</h5>
                                                        <p>{{ date_format(date_create($item->mulai), 'd M Y').' - '.date_format(date_create($item->selesai), 'd M Y') }}</p>
                                                        {{-- <p>{{ $i.'/'.$count }}</p> --}}
                                                    </div>
                                                </div>
                                            @elseif ($active == true)
                                                <div class="timeline__item @if($first == false) first <?php $first = true; ?> @endif @if($i == $count) end @else full @endif @if((strtotime(date("Y-m-d H:i:s")) >= strtotime($item->mulai)) && (strtotime(date("Y-m-d H:i:s")) <= strtotime($item->selesai))) active @endif">
                                                    <div class="timeline__content @if((strtotime(date("Y-m-d H:i:s")) >= strtotime($item->mulai)) && (strtotime(date("Y-m-d H:i:s")) <= strtotime($item->selesai))) active @endif">
                                                        <h5>{{ $item->tahap->nama_tahap }}</h5>
                                                        <p>{{ date_format(date_create($item->mulai), 'd M Y').' - '.date_format(date_create($item->selesai), 'd M Y') }}</p>
                                                        {{-- <p>{{ $i.'/'.$count }}</p> --}}
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="form-group d-flex justify-content-end mb-3">
            <a class="btn btn-danger" href="{{ route('back.program.index') }}">Batal</a>
            <button class="btn btn-success ms-2" type="submit">Simpan</button>
        </div> --}}
    {{-- </form> --}}
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Detail Tahap Program {{ $program->nama_program.' '.$program->tahun }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="m-3" id="listTahap"></div>
        </div>
    </div>
    </div>
</div>

<script>
    function timeline(collection, options) {
        const timelines = [];
        const warningLabel = "Timeline:";
        let winWidth = window.innerWidth;

        let resizeTimer;
        let currentIndex = 0;
        // Set default settings
        const defaultSettings = {
            forceVerticalMode: {
                type: "integer",
                defaultValue: 600,
            },
            horizontalStartPosition: {
                type: "string",
                acceptedValues: ["bottom", "top"],
                defaultValue: "top",
            },
            mode: {
                type: "string",
                acceptedValues: ["horizontal", "vertical"],
                defaultValue: "vertical",
            },
            moveItems: {
                type: "integer",
                defaultValue: 1,
            },
            rtlMode: {
                type: "boolean",
                acceptedValues: [true, false],
                defaultValue: false,
            },
            startIndex: {
                type: "integer",
                defaultValue: 0,
            },
            verticalStartPosition: {
                type: "string",
                acceptedValues: ["left", "right"],
                defaultValue: "left",
            },
            verticalTrigger: {
                type: "string",
                defaultValue: "15%",
            },
            visibleItems: {
                type: "integer",
                defaultValue: 3,
            },
        };

        // Helper function to test whether values are an integer
        function testValues(value, settingName) {
            if (typeof value !== "number" && value % 1 !== 0) {
                console.warn(
                    `${warningLabel} The value "${value}" entered for the setting "${settingName}" is not an integer.`
                );
                return false;
            }
            return true;
        }

        // Helper function to wrap an element in another HTML element
        function itemWrap(el, wrapper, classes) {
            wrapper.classList.add(classes);
            el.parentNode.insertBefore(wrapper, el);
            wrapper.appendChild(el);
        }

        // Helper function to wrap each element in a group with other HTML elements
        function wrapElements(items) {
            items.forEach((item) => {
                itemWrap(
                    item.querySelector(".timeline__content"),
                    document.createElement("div"),
                    "timeline__content__wrap"
                );
                itemWrap(
                    item.querySelector(".timeline__content__wrap"),
                    document.createElement("div"),
                    "timeline__item__inner"
                );
            });
        }

        // Helper function to check if an element is partially in the viewport
        function isElementInViewport(el, triggerPosition) {
            const rect = el.getBoundingClientRect();
            const windowHeight =
                window.innerHeight || document.documentElement.clientHeight;
            const defaultTrigger =
                defaultSettings.verticalTrigger.defaultValue.match(/(\d*\.?\d*)(.*)/);
            let triggerUnit = triggerPosition.unit;
            let triggerValue = triggerPosition.value;
            let trigger = windowHeight;
            if (triggerUnit === "px" && triggerValue >= windowHeight) {
                console.warn(
                    'The value entered for the setting "verticalTrigger" is larger than the window height. The default value will be used instead.'
                );
                [, triggerValue, triggerUnit] = defaultTrigger;
            }
            if (triggerUnit === "px") {
                trigger = parseInt(trigger - triggerValue, 10);
            } else if (triggerUnit === "%") {
                trigger = parseInt(trigger * ((100 - triggerValue) / 100), 10);
            }
            return (
                rect.top <= trigger &&
                rect.left <=
                    (window.innerWidth || document.documentElement.clientWidth) &&
                rect.top + rect.height >= 0 &&
                rect.left + rect.width >= 0
            );
        }

        // Helper function to add transform styles
        function addTransforms(el, transform) {
            el.style.webkitTransform = transform;
            el.style.msTransform = transform;
            el.style.transform = transform;
        }

        // Create timelines
        function createTimelines(timelineEl) {
            const timelineName = timelineEl.id
                ? `#${timelineEl.id}`
                : `.${timelineEl.className}`;
            const errorPart = "could not be found as a direct descendant of";
            const data = timelineEl.dataset;
            let wrap;
            let scroller;
            let items;
            const settings = {};

            // Test for correct HTML structure
            try {
                wrap = timelineEl.querySelector(".timeline__wrap");
                if (!wrap) {
                    throw new Error(
                        `${warningLabel} .timeline__wrap ${errorPart} ${timelineName}`
                    );
                } else {
                    scroller = wrap.querySelector(".timeline__items");
                    if (!scroller) {
                        throw new Error(
                            `${warningLabel} .timeline__items ${errorPart} .timeline__wrap`
                        );
                    } else {
                        items = [].slice.call(scroller.children, 0);
                    }
                }
            } catch (e) {
                console.warn(e.message);
                return false;
            }

            // Test setting input values
            Object.keys(defaultSettings).forEach((key) => {
                settings[key] = defaultSettings[key].defaultValue;

                if (data[key]) {
                    settings[key] = data[key];
                } else if (options && options[key]) {
                    settings[key] = options[key];
                }

                if (defaultSettings[key].type === "integer") {
                    if (!settings[key] || !testValues(settings[key], key)) {
                        settings[key] = defaultSettings[key].defaultValue;
                    }
                } else if (defaultSettings[key].type === "string") {
                    if (
                        defaultSettings[key].acceptedValues &&
                        defaultSettings[key].acceptedValues.indexOf(settings[key]) === -1
                    ) {
                        console.warn(
                            `${warningLabel} The value "${settings[key]}" entered for the setting "${key}" was not recognised.`
                        );
                        settings[key] = defaultSettings[key].defaultValue;
                    }
                }
            });

            // Further specific testing of input values
            const defaultTrigger =
                defaultSettings.verticalTrigger.defaultValue.match(/(\d*\.?\d*)(.*)/);
            const triggerArray = settings.verticalTrigger.match(/(\d*\.?\d*)(.*)/);
            let [, triggerValue, triggerUnit] = triggerArray;
            let triggerValid = true;
            if (!triggerValue) {
                console.warn(
                    `${warningLabel} No numercial value entered for the 'verticalTrigger' setting.`
                );
                triggerValid = false;
            }
            if (triggerUnit !== "px" && triggerUnit !== "%") {
                console.warn(
                    `${warningLabel} The setting 'verticalTrigger' must be a percentage or pixel value.`
                );
                triggerValid = false;
            }
            if (triggerUnit === "%" && (triggerValue > 100 || triggerValue < 0)) {
                console.warn(
                    `${warningLabel} The 'verticalTrigger' setting value must be between 0 and 100 if using a percentage value.`
                );
                triggerValid = false;
            } else if (triggerUnit === "px" && triggerValue < 0) {
                console.warn(
                    `${warningLabel} The 'verticalTrigger' setting value must be above 0 if using a pixel value.`
                );
                triggerValid = false;
            }

            if (triggerValid === false) {
                [, triggerValue, triggerUnit] = defaultTrigger;
            }

            settings.verticalTrigger = {
                unit: triggerUnit,
                value: triggerValue,
            };

            if (settings.moveItems > settings.visibleItems) {
                console.warn(
                    `${warningLabel} The value of "moveItems" (${settings.moveItems}) is larger than the number of "visibleItems" (${settings.visibleItems}). The value of "visibleItems" has been used instead.`
                );
                settings.moveItems = settings.visibleItems;
            }

            if (
                settings.startIndex > items.length - settings.visibleItems &&
                items.length > settings.visibleItems
            ) {
                console.warn(
                    `${warningLabel} The 'startIndex' setting must be between 0 and ${
                        items.length - settings.visibleItems
                    } for this timeline. The value of ${
                        items.length - settings.visibleItems
                    } has been used instead.`
                );
                settings.startIndex = items.length - settings.visibleItems;
            } else if (items.length <= settings.visibleItems) {
                console.warn(
                    `${warningLabel} The number of items in the timeline must exceed the number of visible items to use the 'startIndex' option.`
                );
                settings.startIndex = 0;
            } else if (settings.startIndex < 0) {
                console.warn(
                    `${warningLabel} The 'startIndex' setting must be between 0 and ${
                        items.length - settings.visibleItems
                    } for this timeline. The value of 0 has been used instead.`
                );
                settings.startIndex = 0;
            }

            timelines.push({
                timelineEl,
                wrap,
                scroller,
                items,
                settings,
            });
        }

        if (collection.length) {
            [].forEach.call(collection, createTimelines);
        }

        // Set height and widths of timeline elements and viewport
        function setHeightandWidths(tl) {
            // Set widths of items and viewport
            function setWidths() {
                tl.itemWidth = tl.wrap.offsetWidth / tl.settings.visibleItems;
                tl.items.forEach((item) => {
                    item.style.width = `${tl.itemWidth}px`;
                });
                tl.scrollerWidth = tl.itemWidth * tl.items.length;
                tl.scroller.style.width = `${tl.scrollerWidth}px`;
            }

            // Set height of items and viewport
            function setHeights() {
                let oddIndexTallest = 0;
                let evenIndexTallest = 0;
                tl.items.forEach((item, i) => {
                    item.style.height = "auto";
                    const height = item.offsetHeight;
                    if (i % 2 === 0) {
                        evenIndexTallest =
                            height > evenIndexTallest ? height : evenIndexTallest;
                    } else {
                        oddIndexTallest = height > oddIndexTallest ? height : oddIndexTallest;
                    }
                });

                const transformString = `translateY(${evenIndexTallest}px)`;
                tl.items.forEach((item, i) => {
                    if (i % 2 === 0) {
                        item.style.height = `${evenIndexTallest}px`;
                        if (tl.settings.horizontalStartPosition === "bottom") {
                            item.classList.add("timeline__item--bottom");
                            addTransforms(item, transformString);
                        } else {
                            item.classList.add("timeline__item--top");
                        }
                    } else {
                        item.style.height = `${oddIndexTallest}px`;
                        if (tl.settings.horizontalStartPosition !== "bottom") {
                            item.classList.add("timeline__item--bottom");
                            addTransforms(item, transformString);
                        } else {
                            item.classList.add("timeline__item--top");
                        }
                    }
                });
                tl.scroller.style.height = `${evenIndexTallest + oddIndexTallest}px`;
            }

            if (window.innerWidth > tl.settings.forceVerticalMode) {
                setWidths();
                setHeights();
            }
        }

        // Create and add arrow controls to horizontal timeline
        function addNavigation(tl) {
            if (tl.items.length > tl.settings.visibleItems) {
                const prevArrow = document.createElement("button");
                const nextArrow = document.createElement("button");
                const topPosition = tl.items[0].offsetHeight;
                prevArrow.className = "timeline-nav-button timeline-nav-button--prev";
                nextArrow.className = "timeline-nav-button timeline-nav-button--next";
                prevArrow.textContent = "Previous";
                nextArrow.textContent = "Next";
                prevArrow.style.top = `${topPosition}px`;
                nextArrow.style.top = `${topPosition}px`;
                if (currentIndex === 0) {
                    prevArrow.disabled = true;
                } else if (currentIndex === tl.items.length - tl.settings.visibleItems) {
                    nextArrow.disabled = true;
                }
                tl.timelineEl.appendChild(prevArrow);
                tl.timelineEl.appendChild(nextArrow);
            }
        }

        // Add the centre line to the horizontal timeline
        function addHorizontalDivider(tl) {
            const divider = tl.timelineEl.querySelector(".timeline-divider");
            if (divider) {
                tl.timelineEl.removeChild(divider);
            }
            const topPosition = tl.items[0].offsetHeight;
            const horizontalDivider = document.createElement("span");
            horizontalDivider.className = "timeline-divider";
            horizontalDivider.style.top = `${topPosition}px`;
            tl.timelineEl.appendChild(horizontalDivider);
        }

        // Calculate the new position of the horizontal timeline
        function timelinePosition(tl) {
            const position = tl.items[currentIndex].offsetLeft;
            const str = `translate3d(-${position}px, 0, 0)`;
            addTransforms(tl.scroller, str);
        }

        // Make the horizontal timeline slide
        function slideTimeline(tl) {
            const navArrows = tl.timelineEl.querySelectorAll(".timeline-nav-button");
            const arrowPrev = tl.timelineEl.querySelector(".timeline-nav-button--prev");
            const arrowNext = tl.timelineEl.querySelector(".timeline-nav-button--next");
            const maxIndex = tl.items.length - tl.settings.visibleItems;
            const moveItems = parseInt(tl.settings.moveItems, 10);
            [].forEach.call(navArrows, (arrow) => {
                arrow.addEventListener("click", function (e) {
                    e.preventDefault();
                    currentIndex = this.classList.contains("timeline-nav-button--next")
                        ? (currentIndex += moveItems)
                        : (currentIndex -= moveItems);
                    if (currentIndex === 0 || currentIndex < 0) {
                        currentIndex = 0;
                        arrowPrev.disabled = true;
                        arrowNext.disabled = false;
                    } else if (currentIndex === maxIndex || currentIndex > maxIndex) {
                        currentIndex = maxIndex;
                        arrowPrev.disabled = false;
                        arrowNext.disabled = true;
                    } else {
                        arrowPrev.disabled = false;
                        arrowNext.disabled = false;
                    }
                    timelinePosition(tl);
                });
            });
        }

        // Set up horizontal timeline
        function setUpHorinzontalTimeline(tl) {
            if (tl.settings.rtlMode) {
                currentIndex =
                    tl.items.length > tl.settings.visibleItems
                        ? tl.items.length - tl.settings.visibleItems
                        : 0;
            } else {
                currentIndex = tl.settings.startIndex;
            }
            tl.timelineEl.classList.add("timeline--horizontal");
            setHeightandWidths(tl);
            timelinePosition(tl);
            addNavigation(tl);
            addHorizontalDivider(tl);
            slideTimeline(tl);
        }

        // Set up vertical timeline
        function setUpVerticalTimeline(tl) {
            let lastVisibleIndex = 0;
            tl.items.forEach((item, i) => {
                item.classList.remove("animated", "fadeIn");
                if (!isElementInViewport(item, tl.settings.verticalTrigger) && i > 0) {
                    item.classList.add("animated");
                } else {
                    lastVisibleIndex = i;
                }
                const divider = tl.settings.verticalStartPosition === "left" ? 1 : 0;
                if (
                    i % 2 === divider &&
                    window.innerWidth > tl.settings.forceVerticalMode
                ) {
                    item.classList.add("timeline__item--right");
                } else {
                    item.classList.add("timeline__item--left");
                }
            });
            for (let i = 0; i < lastVisibleIndex; i += 1) {
                tl.items[i].classList.remove("animated", "fadeIn");
            }
            // Bring elements into view as the page is scrolled
            window.addEventListener("scroll", () => {
                tl.items.forEach((item) => {
                    if (isElementInViewport(item, tl.settings.verticalTrigger)) {
                        item.classList.add("fadeIn");
                    }
                });
            });
        }

        // Reset timelines
        function resetTimelines(tl) {
            tl.timelineEl.classList.remove("timeline--horizontal", "timeline--mobile");
            tl.scroller.removeAttribute("style");
            tl.items.forEach((item) => {
                item.removeAttribute("style");
                item.classList.remove(
                    "animated",
                    "fadeIn",
                    "timeline__item--left",
                    "timeline__item--right"
                );
            });
            const navArrows = tl.timelineEl.querySelectorAll(".timeline-nav-button");
            [].forEach.call(navArrows, (arrow) => {
                arrow.parentNode.removeChild(arrow);
            });
        }

        // Set up the timelines
        function setUpTimelines() {
            timelines.forEach((tl) => {
                tl.timelineEl.style.opacity = 0;
                if (!tl.timelineEl.classList.contains("timeline--loaded")) {
                    wrapElements(tl.items);
                }
                resetTimelines(tl);
                if (window.innerWidth <= tl.settings.forceVerticalMode) {
                    tl.timelineEl.classList.add("timeline--mobile");
                }
                if (
                    tl.settings.mode === "horizontal" &&
                    window.innerWidth > tl.settings.forceVerticalMode
                ) {
                    console.log(tl.settings.mode + " " + window.innerWidth);
                    setUpHorinzontalTimeline(tl);
                } else {
                    console.log(tl.settings.mode + " " + window.innerWidth);
                    setUpVerticalTimeline(tl);
                }
                tl.timelineEl.classList.add("timeline--loaded");
                setTimeout(() => {
                    tl.timelineEl.style.opacity = 1;
                }, 500);
            });
        }

        // Initialise the timelines on the page
        setUpTimelines();

        window.addEventListener("resize", () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                const newWinWidth = window.innerWidth;
                if (newWinWidth !== winWidth) {
                    setUpTimelines();
                    winWidth = newWinWidth;
                    console.log(winWidth);
                }
            }, 250);
        });
    }

    // Register as a jQuery plugin if the jQuery library is present
    if (window.jQuery) {
        (($) => {
            $.fn.timeline = function (opts) {
                timeline(this, opts);
                return this;
            };
        })(window.jQuery);
    }

    // const mediaQuery = window.matchMedia("(max-width: 767.98px)");
    // const arrow = document.querySelector(".timeline__arrow");

    // if (mediaQuery.matches) {
    // 	// Then trigger an alert

    // }

    const site_url = '{{ url('') }}';
    const program = '<?php echo json_encode($program) ?>';
    const referensi = JSON.parse(program);
    const idTahap = [];
    $(document).ready(function () {
        let refKegiatanProgram = [];
        $.getJSON(
            `${site_url}/api/kegiatan-program/by_program/${referensi.id}`,
            null,
            function (data, textStatus, jqXHR) {
                if (data != null) {
                    if (data.data != null) {
                        data.data.forEach((element) => {
                            refKegiatanProgram.push(element.kegiatan_id); 
                        });
                    }
                }
            });
        $.getJSON(
            `${site_url}/api/kegiatan`,
            null,
            function (data, textStatus, jqXHR) {
                if (data != null) {
                    if (data.data != null) {
                        count = data.data.length;
                        checklist = `<div class="col-6">`;
                        for(i=0; i<Math.ceil(count/2); i++){
                            checklist += `
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="check`+data.data[i].id+`" name="kegiatan[]" value="`+data.data[i].id+`" `+(refKegiatanProgram.includes(data.data[i].id) ? 'checked' : '')+` onclick="return false;">
                                <label class="form-check-label" for="check`+data.data[i].id+`">`+data.data[i].nama_kegiatan+`</label>
                            </div>
                            `
                        }
                        checklist += `</div><div class="col-6">`
                        for(i=Math.ceil(count/2); i<count; i++){
                            checklist += `
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="check`+data.data[i].id+`" name="kegiatan[]" value="`+data.data[i].id+`" `+(refKegiatanProgram.includes(data.data[i].id) ? 'checked' : '')+` onclick="return false;">
                                <label class="form-check-label" for="check`+data.data[i].id+`">`+data.data[i].nama_kegiatan+`</label>
                            </div>
                            `
                        }
                        checklist += `</div>`
                        $('#listKegiatan').html(checklist);
                    }
                }
            });
            
        // let refTahapProgram = [];
        // $.getJSON(
        //     `${site_url}/api/tahap-program/by_program/${referensi.id}`,
        //     null,
        //     function (data, textStatus, jqXHR) {
        //         tahap = ``;
        //         count = 0;
        //         if (data != null) {
        //             if (data.data != null) {
        //                 data.data.forEach((element) => {
        //                     refTahapProgram.push({ tahap_id: element.tahap_id, mulai: element.mulai, selesai: element.selesai});
        //                     tahap += `
        //                     <div class="row mb-3">
        //                         <div class="form-group">
        //                             <div class="row">
        //                                 <div class="col-6">
        //                                     `+element.nama_tahap+`
        //                                 </div>
        //                                 <div class="col-6">
        //                                     <input class="form-control" id="date-tahap-`+element.tahap_id+`" type="text" name="date_tahap[`+count+`]" value="<?php echo date_format(date_create(`+element.mulai+`), 'd M Y (H:m)').' - '.date_format(date_create(`+element.selesai+`), 'd M Y (H:m)')?>" readonly>
        //                                 </div>
        //                             </div>
        //                         </div>
        //                     </div>
        //                     `;
        //                     count++;
        //                 });
        //             }
        //         }
        //         $('#listTahap').html(tahap);
        //         // refTahapProgram.forEach((element) => {
        //         //     // idTahap.push(element.tahap_id);
        //         //     // console.log(element.mulai)
        //         //     $('#date-tahap-'+element.tahap_id).daterangepicker({
        //         //         timePicker: true,
        //         //         timePicker24Hour: true,
        //         //         autoApply: true,
        //         //         startDate: new Date(element.mulai),
        //         //         endDate: new Date(element.selesai),
        //         //         locale: {
        //         //             format: 'D MMM YYYY (H:mm)'
        //         //         }
        //         //     });
        //         //     $('#date-tahap-'+element.tahap_id).on('apply.daterangepicker', function(ev, picker) {
        //         //         updateDate(element.tahap_id,picker.startDate.format('YYYY-MM-DD HH:MM:ss'),picker.endDate.format('YYYY-MM-DD HH:MM:ss'))
        //         //     });
        //         // })
        //     });

        // $.getJSON(
        //     `${site_url}/api/tahap-program/by_program/${referensi.id}`,
        //     null,
        //     function (data, textStatus, jqXHR) {
        //         tahap = ``;
        //         count = 0;
        //         if (data != null) {
        //             if (data.data != null) {
        //                 data.data.forEach((element) => {
        //                     refTahapProgram.push({ tahap_id: element.tahap_id, mulai: element.mulai, selesai: element.selesai});
        //                     tahap += `
        //                     <div class="timeline__item">
        //                         <div class="timeline__content">
        //                             Content / markup here
        //                         </div>
        //                     </div>
        //                     `;
        //                     // tahap += `
        //                     // <div class="timeline__item top">
        //                     //     <div class="timeline__content">
        //                     //         ${element.nama_tahap}
        //                     //     </div>
        //                     // </div>
        //                     // `;
        //                     count++;
        //                 });
        //             }
        //         }
        //         console.log(tahap)
        //         $('.timeline__items').html(tahap);
        //         // refTahapProgram.forEach((element) => {
        //         //     // idTahap.push(element.tahap_id);
        //         //     // console.log(element.mulai)
        //         //     $('#date-tahap-'+element.tahap_id).daterangepicker({
        //         //         timePicker: true,
        //         //         timePicker24Hour: true,
        //         //         autoApply: true,
        //         //         startDate: new Date(element.mulai),
        //         //         endDate: new Date(element.selesai),
        //         //         locale: {
        //         //             format: 'D MMM YYYY (H:mm)'
        //         //         }
        //         //     });
        //         //     $('#date-tahap-'+element.tahap_id).on('apply.daterangepicker', function(ev, picker) {
        //         //         updateDate(element.tahap_id,picker.startDate.format('YYYY-MM-DD HH:MM:ss'),picker.endDate.format('YYYY-MM-DD HH:MM:ss'))
        //         //     });
        //         // })
        //     });

        // $('.timeline').timeline({
        //     mode: 'horizontal'
        // });

        $('#detailProgram').submit(function (e) {
            e.preventDefault();
            Swal.fire({
                icon: "question",
                title: "Peringatan",
                text: "Apakah Anda yakin ingin mengubah data program?",
                showCancelButton: true,
                cancelButtonText: "Batal",
                confirmButtonText: "Simpan",
                confirmButtonColor: "#008080",
                reverseButtons: true,
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'ajax',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: `${site_url}/back/program/${referensi.id}`,
                        // data: $('#detailProgram').serialize(),
                        data: new FormData($('#detailProgram')[0]),
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        // beforeSend: function () { },
                        success: function (response) {
                            // console.log(response);
                            if ((response.status === 'error')) {
                                Swal.fire('Gagal!', 'Aplikasi gagal terhubung dengan server. Silahkan hubungi admin.', 'error');
                            }
                            if (response.status == 'success') {
                                Swal.fire('Update Berhasil!', response.message, 'success').then(function () {
                                    location.href = site_url+'/back/program';
                                })
                            }
                        },
                        error: function (xmlhttprequest, textstatus, message) {
                            // text status value : abort, error, parseerror, timeout
                            // default xmlhttprequest = xmlhttprequest.responseJSON.message

                            Swal.fire('Gagal!', xmlhttprequest.responseJSON.message, 'error');
                            // console.log(xmlhttprequest.responseJSON);
                        },
                    });
                }
            });
        });

        // $('#form-tahap').submit(function (e) {
        //     e.preventDefault();
        //     Swal.fire({
        //         icon: "question",
        //         title: "Peringatan",
        //         text: "Apakah Anda yakin ingin mengubah data tahap program?",
        //         showCancelButton: true,
        //         cancelButtonText: "Batal",
        //         confirmButtonText: "Simpan",
        //         confirmButtonColor: "#008080",
        //         reverseButtons: true,
        //     }).then((result) => {
        //         if (result.value) {
        //             $.ajax({
        //                 type: 'ajax',
        //                 method: 'POST',
        //                 headers: {
        //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //                 },
        //                 url: `${site_url}/program/date-tahap-program/${referensi.id}`,
        //                 // data: $('#detailProgram').serialize(),
        //                 // data: {
        //                 //     id : idTahap,
        //                 //     data : new FormData($('#form-tahap')[0]),
        //                 // },
        //                 data : new FormData($('#form-tahap')[0]),
        //                 contentType: false,
        //                 processData: false,
        //                 dataType: 'json',
        //                 // beforeSend: function () { },
        //                 success: function (response) {
        //                     console.log(response);
        //                     // if ((response.status === 'error')) {
        //                     //     Swal.fire('Gagal!', 'Aplikasi gagal terhubung dengan server. Silahkan hubungi admin.', 'error');
        //                     // }
        //                     // if (response.status == 'success') {
        //                     //     Swal.fire('Pendataan Berhasil!', response.message, 'success').then(function () {
        //                     //         location.href = site_url+'/program';
        //                     //     })
        //                     // }
        //                 },
        //                 error: function (xmlhttprequest, textstatus, message) {
        //                     // text status value : abort, error, parseerror, timeout
        //                     // default xmlhttprequest = xmlhttprequest.responseJSON.message

        //                     Swal.fire('Gagal!', xmlhttprequest.responseJSON.message, 'error');
        //                     // console.log(xmlhttprequest.responseJSON);
        //                 },
        //             });
        //         }
        //     });
        // });
        $('.timeline').timeline({
            // mode:'horizontal',
            visibleItems: 3
        });

    });

    function updateDate(id, mulai, selesai){
        Swal.fire({
            icon: "question",
            title: "Peringatan",
            text: "Apakah Anda yakin ingin mengubah data tahap program?",
            showCancelButton: true,
            cancelButtonText: "Batal",
            confirmButtonText: "Simpan",
            confirmButtonColor: "#008080",
            reverseButtons: true,
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'ajax',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `${site_url}/back/program/date-tahap-program/${referensi.id}`,
                    data: {
                        id : id,
                        mulai : mulai,
                        selesai : selesai,
                    },
                    // contentType: false,
                    // processData: false,
                    dataType: 'json',
                    // beforeSend: function () { },
                    success: function (response) {
                        // console.log(response);
                        if ((response.status === 'error')) {
                            Swal.fire('Gagal!', 'Aplikasi gagal terhubung dengan server. Silahkan hubungi admin.', 'error');
                        }
                        if (response.status == 'success') {
                            Swal.fire('Update Berhasil!', response.message, 'success').then(function () {
                                // location.href = site_url+'/program';
                            })
                        }
                    },
                    error: function (xmlhttprequest, textstatus, message) {
                        // text status value : abort, error, parseerror, timeout
                        // default xmlhttprequest = xmlhttprequest.responseJSON.message

                        Swal.fire('Gagal!', xmlhttprequest.responseJSON.message, 'error');
                        // console.log(xmlhttprequest.responseJSON);
                    },
                });
            }
        });
    }
</script>
@endsection    