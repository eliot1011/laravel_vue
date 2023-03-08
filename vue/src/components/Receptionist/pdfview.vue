<template>
  <div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
      <tr class="top">
        <td colspan="4">
          <table>
            <tr>
              <td class="title">
                <strong>Diagnostic Center</strong>
              </td>

              <td>
                Invoice #: {{ patientInfo.id }}<br />
                Created: {{ patientInfo.created_at }}<br />
              </td>
            </tr>
          </table>
        </td>
      </tr>

      <tr class="information">
        <td colspan="4">
          <table>
            <tr>
              <td>
                Diagnostic Center<br />
                12345 Minhaz Road<br />
                Shundorpur, MUK 1419
              </td>

              <td>
                Patient Name: {{ patientInfo.name }}<br />
                <span>Patient ID: {{ patientInfo.patient_id }}</span
                ><br />Patient Email: {{ patientInfo.email }} <br /><span
                  >Patient Mobile No.: {{ patientInfo.phone }}</span
                >
              </td>
            </tr>
          </table>
        </td>
      </tr>

      <tr class="heading">
        <td>ID</td>
        <td>Item</td>
        <td>Unit Cost</td>
        <td>Price</td>
      </tr>


      <tr class="item" >
        <td>{{patientInfo2.test_id}}</td>
      <td>{{patientInfo2.test_name}}</td>
      <td>{{patientInfo2.advance}}</td>
      <td>BDT {{patientInfo2.name}}</td>
    </tr>

      <tr class="total">
        <td colspan="3"></td>
        <td>Total: $</td>
      </tr>
    </table>
  </div>
</template><script>
export default {
  data() {
    return {
      id: this.$route.params.id,
      filter: "",
      perPage: 5,
      currentPage: 1,
      fields: [
        { key: "patient_id", label: "ID" },
        { key: "name", label: "Name" },
        { key: "due", label: "Due" },
        "Actions",
      ],
      patient: [],
      patientInfo: {},
      form: {
        pay: 0,
        //due:0,
      },
      due: 0,
    };
  },

  computed: {
    rows() {
      return this.patients.length;
    },
  },

  created() {
    //patients er test gula array tah nissi
    this.$http
      .get("http://127.0.0.1:8000/api/patientDetails/" + this.id)
      .then((response) => {
        this.patient = response.data.patient;
      });
    //patient er details
    this.$http
      .get("http://127.0.0.1:8000/api/latestPatient/" + this.id)
      .then((response) => {
        this.patientInfo = response.data;
      });

  },

  methods: {
    onFiltered(filteredItems) {
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },

    getSingleData() {
      this.$http
        .get("http://127.0.0.1:8000/api/patientInfo/" + this.id)
        .then((response) => {
          this.patientInfo = response.data;
        });
    },

    updatePatientPayment() {
      this.$http
        .post(
          "http://127.0.0.1:8000/api/updatePatientPayment/" + this.id,
          this.form
        )
        .then(() => {
          this.getSingleData(),
            (this.form.pay = 0),
            (self.message = "Data is entered");
        });
    },

    l(){

       this.$http
      .get("http://127.0.0.1:8000/api/latestPatientReport/" + this.patient.patient_id)
      .then((response) => {
        this.patientInfo2 = response.data;
      });
    }
  },
};
</script>

<style scoped>
.invoice-box {
  max-width: 800px;
  margin: auto;
  padding: 30px;
  border: 1px solid #eee;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
  font-size: 16px;
  line-height: 24px;
  font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
  color: #555;
}

.invoice-box table {
  width: 100%;
  line-height: inherit;
  text-align: left;
}

.invoice-box table td {
  padding: 5px;
  vertical-align: top;
}

.invoice-box table tr td:nth-child(n + 2) {
  text-align: right;
}

.invoice-box table tr.top table td {
  padding-bottom: 20px;
}

.invoice-box table tr.top table td.title {
  font-size: 45px;
  line-height: 45px;
  color: #333;
}

.invoice-box table tr.information table td {
  padding-bottom: 40px;
}

.invoice-box table tr.heading td {
  background: #eee;
  border-bottom: 1px solid #ddd;
  font-weight: bold;
}

.invoice-box table tr.details td {
  padding-bottom: 20px;
}

.invoice-box table tr.item td {
  border-bottom: 1px solid #eee;
}

.invoice-box table tr.item.last td {
  border-bottom: none;
}

.invoice-box table tr.item input {
  padding-left: 5px;
}

.invoice-box table tr.item td:first-child input {
  margin-left: -5px;
  width: 100%;
}

.invoice-box table tr.total td:nth-child(2) {
  border-top: 2px solid #eee;
  font-weight: bold;
}

.invoice-box input[type="number"] {
  width: 60px;
}

@media only screen and (max-width: 600px) {
  .invoice-box table tr.top table td {
    width: 100%;
    display: block;
    text-align: center;
  }

  .invoice-box table tr.information table td {
    width: 100%;
    display: block;
    text-align: center;
  }
}

/** RTL **/
.rtl {
  direction: rtl;
  font-family: Tahoma, "Helvetica Neue", "Helvetica", Helvetica, Arial,
    sans-serif;
}

.rtl table {
  text-align: right;
}

.rtl table tr td:nth-child(2) {
  text-align: left;
}
</style>