<template>
  <default-field :field="field" :errors="errors">
    <template slot="field">
      <input
        type="text"
        v-show="true"
        id="address_line_1_input"
        class="w-full form-control form-input form-input-bordered mt-3"
        :class="errorClasses"
        placeholder="Address line 1"
        :v-bind="address_line_1_input"
        v-model="address_line_1_input"
      />

      <input
        type="text"
        v-show="true"
        id="address_line_2_input"
        class="w-full form-control form-input form-input-bordered mt-3"
        :class="errorClasses"
        placeholder="Address line 2"
        :v-bind="address_line_2_input"
        v-model="address_line_2_input"
      />

      <input
        type="text"
        v-show="true"
        id="suburb_input"
        class="w-full form-control form-input form-input-bordered mt-3"
        :class="errorClasses"
        placeholder="Suburb Name"
        :v-bind="suburb_input"
        v-model="suburb_input"
      />

      <input
        type="text"
        v-show="true"
        id="postal_code_input"
        class="w-full form-control form-input form-input-bordered mt-3"
        :class="errorClasses"
        placeholder="Postal Code"
        :v-bind="postal_code_input"
        v-model="postal_code_input"
      />

      <button
        v-show="!show_details"
        class="btn btn-default mt-3 btn-primary inline-flex items-center relative mr-3"
        v-on:click.prevent="checkAddress"
      >Check Address</button>

      <button
        v-show="show_details"
        class="btn btn-default mt-3 btn-danger inline-flex items-center relative"
        v-on:click.prevent="clear"
      >Clear</button>

      <div v-show="show_details">
        <label class="inline-block text-80 pt-2 leading-tight">Suburb : {{ suburb_output }}</label>
        <br />

        <label class="inline-block text-80 pt-2 leading-tight">Matched Route : {{ matched_route }}</label>
        <br />

        <label
          class="inline-block text-80 pt-2 leading-tight"
        >Google Address Accuracy : {{ google_address_accuracy }}</label>
        <br />

        <label
          class="inline-block text-80 pt-2 leading-tight"
        >Google Formatted Address : {{ google_formatted_address }}</label>
        <br />

        <iframe
          style="border-radius:5px;"
          :src="google_map_url"
          width="100%"
          height="400"
          frameborder="0"
        ></iframe>

        <!-- <div style="height:500px;width:160%;" class="w-3/4 py-4 mt-3">
          <l-map
            style="border-radius:5px;"
            ref="map"
            :zoom="zoom"
            :center="center"
            @click="addMarker"
          >
            <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
            <l-marker :lat-lng="marker" :icon="myMarkerIcon" :visible="true"></l-marker>
          </l-map>
        </div>-->
      </div>
    </template>
  </default-field>
</template>

<script>
import L from "leaflet";

import { FormField, HandlesValidationErrors } from "laravel-nova";
import qs from "qs";

// import { LMap, LTileLayer, LMarker, LIcon } from "vue2-leaflet";
// import "leaflet/dist/leaflet.css";

export default {
  //   components: {
  //     "l-map": LMap,
  //     "l-tile-layer": LTileLayer,
  //     "l-marker": LMarker
  //   },

  mixins: [FormField, HandlesValidationErrors],

  props: ["resourceName", "resourceId", "field", "endPoint"],

  data: function() {
    // const myMarkerIcon = L.icon({
    //   iconUrl: "http://haythem.test/haythem/CheckAddress/marker-icon.png",
    //   shadowUrl: "http://haythem.test/haythem/CheckAddress/marker-icon.png",
    //   iconRetinaUrl: "http://haythem.test/haythem/CheckAddress/marker-icon.png"
    // });
    return {
      show_details: false,
      apiResponse: null,
      google_map_url:
        "https://maps.google.com/maps?q=0.0,0.0&z=11&output=embed",
      address_line_1_input: "",
      address_line_2_input: "",
      suburb_input: "",
      postal_code_input: "",
      suburb_output: "No Result",
      matched_route: "No Mactched Route",
      google_address_accuracy: "No Result",
      google_formatted_address: "No Result"

      //   map: null,
      //   zoom: 16,
      //   lat: "0.00000000",
      //   lng: "0.00000000",
      //   center: L.latLng("0.00000000", "0.00000000"),
      //   url: "http://{s}.tile.osm.org/{z}/{x}/{y}.png",
      //   attribution:
      //     '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
      //   marker: L.latLng("0.00000000", "0.00000000"),
      //   myMarkerIcon: myMarkerIcon
    };
  },
  mounted() {
    this.address_line_1_input = this.field.initialAddressLine1;
    this.address_line_2_input = this.field.initialAddressLine2;
    this.suburb_input = this.field.initialSuburb;
    this.postal_code_input = this.field.initialPostalCode;
  },

  methods: {
    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      this.value = this.field.value || "";
    },
    checkAddress() {
      // alert(this.field.endPoint);
      this.show_details = true;
      var data = {
        address_line_1_input: this.address_line_1_input,
        address_line_2_input: this.address_line_2_input,
        suburb_input: this.suburb_input,
        postal_code_input: this.postal_code_input
      };

      console.log("data sent");
      console.log(data);

      axios
        .post(this.field.endPoint, {
          headers: {
            "Access-Control-Allow-Origin": "*",
            "Access-Control-Allow-Headers": "application/json",
            "Content-Type": "application/json",
            Accept: "application/json",
            "Access-Control-Allow-Methods": "POST"
          },
          data
        })
        .then(response => {
          this.apiResponse = response.data;

          this.suburb_output = this.apiResponse.suburb;
          this.google_address_accuracy = this.apiResponse.google_address_accuracy;
          this.google_formatted_address = this.apiResponse.google_formatted_address;
          this.matched_route = this.apiResponse.matched_route;
          console.log("data recieved");
          console.log(this.apiResponse);

          this.google_map_url =
            "https://maps.google.com/maps?q=" +
            this.apiResponse.delivery_lat +
            "," +
            this.apiResponse.delivery_lng +
            "&z=11&output=embed";
          console.log(this);
        })
        .catch(error => {
          console.log(error);
        });
    },
    clear() {
      this.suburb_output = "";
      this.google_address_accuracy = "";
      this.google_formatted_address = "";
      this.matched_route = "";
      this.show_details = false;
      this.google_map_url =
        "https://maps.google.com/maps?q=" +
        this.apiResponse.delivery_lat +
        "," +
        this.apiResponse.delivery_lng +
        "&z=11&output=embed";
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      formData.append(this.field.attribute, this.value || "");
    },

    /**
     * Update the field's internal value.
     */
    handleChange(value) {
      this.value = value;
    }
  }
};
</script>
